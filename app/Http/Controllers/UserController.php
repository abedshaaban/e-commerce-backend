<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    public function get_user_info(Request $request)
    {
        return  response()->json(auth()->payload());
    }
}