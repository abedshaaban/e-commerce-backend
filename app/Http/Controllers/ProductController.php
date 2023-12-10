<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create_product(Request $request){
        $token_data = auth()->payload();

        
        if(!$token_data['privilege'] === 'seller'){
            return response()->json([
                'status' => 'error',
                'message' => 'not authorized.',
            ], 401);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::create([
            'name' => $request-> name,
            'description' => $request-> description,
            'price' => $request-> price,
            'quantity' => $request-> quantity,
            'seller_id' => $token_data['uuid']
        ]);

        return response()->json($product);

    }
}
