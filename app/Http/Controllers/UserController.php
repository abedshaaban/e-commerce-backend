<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(){
        return 'new user created';
    }

    public function sign_in(){
        return 'hello user';
    }
}
