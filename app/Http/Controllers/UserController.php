<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\UserMajorEnum;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        $majors = UserMajorEnum::class;
        return view('user.profile', ['user' => $user, 'majors' => $majors]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        app(UpdateUserProfileInformation::class)->update($user, $request->all());
        return to_route('user.profile.index');
    }

    public function password(Request $request){
        $user = auth()->user();
        app(UpdateUserPassword::class)->update($user, $request->all());
        return to_route('user.profile.index');
    }

}
