<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function register(Request $request){

        $request->validate(['email' => 'required|email']);
        $request->validate(['password' => 'required|min:6']);

        $new_user = User::create([
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
        ]);
    }

    public function sign_in(Request $request){
        $user = [];

        $user["email"] = $request->email;
        $user["password"] = $request->password;

        return $user;
    }
}
