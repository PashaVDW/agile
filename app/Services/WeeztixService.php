<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Token;
use App\Models\User;
use GuzzleHttp\Client;

class WeeztixService
{
    public function callback($request)
    {
        $state = $request->session()->pull('state');

        $response = (new Client)->post('https://auth.openticket.tech/tokens', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => config('app.oauth_client_id'),
                'client_secret' => config('app.oauth_client_secret'),
                'redirect_uri' => config('app.oauth_redirect_uri'),
                'code' => $request->code,
            ],
        ]);

        $data = json_decode((string) $response->getBody(), true);

        // Save the tokens to the database
        Token::create([
            'access_token' => encrypt($data['access_token']),
            'refresh_token' => encrypt($data['refresh_token']),
            'expires_in' => $data['expires_in'],
            'refresh_token_expires_in' => $data['refresh_token_expires_in'],
            'guid' => $data['info']['companies'][0]['guid'],
        ]);
    }

    public function refreshToken()
    {
        $refreshToken = decrypt(Token::first()->refresh_token);

        try {
            $response = (new Client)->post('https://auth.openticket.tech/tokens', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                    'client_id' => config('app.oauth_client_id'),
                    'client_secret' => config('app.oauth_client_secret'),
                ],
            ]);

            $data = json_decode((string) $response->getBody(), true);

            // Update the tokens in the database
            $token = Token::first();
            $token->update([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_in' => $data['expires_in'],
                'refresh_token_expires_in' => $data['refresh_token_expires_in'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to refresh token: ' . $e->getMessage());
        }
    }


    public function getEvents(): array
    {
        $response = $this->makeCurlUrlRequest('https://api.weeztix.com/event/');
        $responseData = json_decode($response, true);
        return array_column($responseData, 'name', 'guid');
    }

    public function getEventCapacity($eventId)
    {
        $response = $this->makeCurlUrlRequest('https://api.weeztix.com/event/' . $eventId . '/ticket');
        $responseData = json_decode($response, true);

        $totalSoldCount = array_sum(array_column($responseData, 'sold_count'));
        $totalAvailableCount = array_sum(array_column($responseData, 'available_stock'));

        $availability = $totalSoldCount / $totalAvailableCount * 100;

        return $availability;
    }

    public function registerUserEvent($eventId)
    {
        $accessToken = decrypt(Token::first()->access_token);
        $GUID = Token::first()->guid;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $accessToken",
                "Company: $GUID"
            ],
            CURLOPT_URL => "https://api.weeztix.com/statistics/event/$eventId"
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $responseData = json_decode($response, true);

        if (isset($responseData['hits']['hits']) && is_array($responseData['hits']['hits'])) {
            foreach ($responseData['hits']['hits'] as $index => $hit) {
                $metaData = $hit['_source']['meta_data'] ?? [];
                $value = $metaData[2]['value'] ?? null;
                \Log::info('Meta data', [
                    'index' => $index,
                    'value' => $value,
                    'event_id' => $eventId,
                    'user_id' => $hit['_source']['user_id'] ?? null,
                ]);

                if ($value) {
                    $phone = substr($value, -8);
                    $userId = User::where('phone', 'like', '%' . $phone)->value('id');
                    $eventDbId = Event::where('weeztix_event_id', $eventId)->value('id');

                    if ($eventDbId && $userId) {
                        if(!User::find($userId)->registeredEvents()->where('event_id', $eventDbId)->exists()) {;
                            User::find($userId)->registeredEvents()->attach($eventId, [
                                'event_id' => $eventDbId,
                                'user_id' => $userId,
                            ]);
                        }
//                        else {
//                            \Log::info('Event already registered for user', [
//                                'event_id' => $eventDbId,
//                                'user_id' => $userId,
//                            ]);;
//                        }
                    } else {
//                        \Log::error('Event or User not found', [
//                            'event_id' => $eventDbId,
//                            'user_id' => $userId,
//                        ]);
                    }
                }
            }
        } else {
            \Log::error('No hits found in API response', $responseData);
        }
    }

    private function makeCurlUrlRequest($url)
    {
        $curl = curl_init();
        $GUID = Token::first()->guid;
        $accessToken = decrypt(Token::first()->access_token);

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
        return $response;
    }
}
