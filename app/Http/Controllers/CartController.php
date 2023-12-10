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

    public function get_cart_ids(){
        $token_data = auth()->payload();

        $cart = Cart::
        select('id')
        ->where('user_id',$token_data['uuid'])
        ->get();

        return response()->json($cart);

    }

    public function get_cart_by_id($id){
        // to do, return cart items.

        return response()->json($id);

    }
}
