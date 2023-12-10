<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    //

    public function create_cart(){
        $token_data = auth()->payload();


        $cart = Cart::create([
            "user_id"=> $token_data['uuid'],
        ]);

        return response()->json($cart);

    }
}
