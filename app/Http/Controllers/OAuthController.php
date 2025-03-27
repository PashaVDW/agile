<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OAuthToken;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class OAuthController extends Controller
{
     public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        $response = (new Client)->post('https://auth.openticket.tech/tokens', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => env('OAUTH_CLIENT_ID', ''),
                'client_secret' => env('OAUTH_CLIENT_SECRET', ''),
                'redirect_uri' => env('OAUTH_CLIENT_REDIRECT', ''),
                'code' => $request->code,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        // Save the tokens to the database
        OAuthToken::create([
            'user_id' => auth()->id(),
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires_in' => $data['expires_in'],
            'refresh_token_expires_in' => $data['refresh_token_expires_in'],
        ]);
        session(['guid' => $data['guid']]);

        return redirect()->route('home');
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = $request->input('refresh_token');

        try {
            $response = (new Client)->post('https://auth.openticket.tech/tokens', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => env('OAUTH_CLIENT_ID', ''),
                    'client_secret' => env('OAUTH_CLIENT_SECRET', ''),
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            // Update the tokens in the database
            $token = OAuthToken::where('user_id', auth()->id())->first();
            $token->update([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_in' => $data['expires_in'],
                'refresh_token_expires_in' => $data['refresh_token_expires_in'],
            ]);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to refresh token'], 401);
        }
    }

    public function getCompany()
    {
        $accessToken = OAuthToken::where('user_id', auth()->id())->first()->access_token;
        $GUID = session('guid');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $accessToken",
                "Company: $GUID"
            ],
            CURLOPT_URL => "https://auth.weeztix.com/users/me"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return response()->json(json_decode($response, true));
    }

    public function getShop() {

        $curl = curl_init();
        $GUID = session('guid');
        $accessToken = OAuthToken::where('user_id', auth()->id())->first()->access_token;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.weeztix.com/shop/' . $GUID,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "Company: $GUID",
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
