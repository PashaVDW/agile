<?php

namespace App\Http\Controllers;

use App\Enums\UserMajorEnum;


class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        $majors = UserMajorEnum::class;
        return view('user.profile', ['user' => $user, 'majors' => $majors]);
    }

    /*public function update(UserRequest $request, $id)
    {
        $this->userService->updateEvent($request, $id);
        return to_route('user.profile.index');
    }*/

}
