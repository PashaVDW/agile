<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\UpdateUserPassword;
use App\Enums\UserMajorEnum;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        $majors = UserMajorEnum::class;
        return view('user.profile', ['user' => $user, 'majors' => $majors]);
    }

    public function update()
    {
        dd("aaaa");
        //$this->userService->updateEvent($request, $id);
        return to_route('user.profile.index');
    }

    public function password(Request $request){
        $user = auth()->user();
        app(UpdateUserPassword::class)->update($user, $request->all());
        return to_route('user.profile.index');
    }

}
