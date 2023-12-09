<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Payload;


class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function get_user_info(Request $request)
    {
        // $token = $request->bearerToken(); 
        // $user = Auth::user();

        // $info = JWT->parseToken($token);

        // $payload = new Payload();


 

        // return response()->json($payload->get());
    }
}