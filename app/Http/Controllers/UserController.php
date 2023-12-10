<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilities\Helpers;


class UserController extends Controller
{
    public function get_user_info(Request $request)
    {
        $user = [];
        $token_data = auth()->payload();

        $user['uuid'] = $token_data->get('uuid');
        $user['email'] = $token_data->get('email');
        $user['f_name'] = $token_data->get('f_name');
        $user['l_name'] = $token_data->get('l-name');
        $user['role'] = $token_data->get('role');

        return  response()->json($user);
    }
}