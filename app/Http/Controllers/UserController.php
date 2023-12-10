<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function get_user_info()
    {
        $token_data = auth()->payload();

        $user = User::
        select('uuid', 'email', 'f_name', 'l_name', 'roles.name')
        ->join('roles', 'users.role_id','=','roles.id')
        ->where('email', $token_data['email'])->first();

        return  response()->json($user);
    }

    public function update_user_info(Request $request)
    {
        $token_data = auth()->payload();

        $user = User::
        select('uuid', 'email', 'f_name', 'l_name', 'roles.name')
        ->join('roles', 'users.role_id','=','roles.id')
        ->where('email', $token_data['email'])->first();

        $user->update([
            "f_name" => $request->f_name ?? $user->f_name,
            "l_name" => $request->l_name ?? $user->l_name
        ]);

        return response()->json($user);
    }
}