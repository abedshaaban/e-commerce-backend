<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function create_user_address()
    {
        $token_data = auth()->payload();

        $address = Address::create([
            'user_id' => $token_data['uuid']
        ]);

        return  response()->json($address);
    }

    public function get_user_address()
    {
        $token_data = auth()->payload();

        $address = Address::
        select('id', 'country', 'city', 'zip_code', 'address')
        ->where('user_id', $token_data['uuid'])->get();

        return  response()->json($address);
    }

    public function update_user_address(Request $request)
    {
        $token_data = auth()->payload();
        $address_id = $request->id;

        if(!$address_id){
            return response()->json([
                'status' => 'error',
                'message' => 'no id for address found.',
            ]);
        }

        $address = Address::
        where('id', $address_id)
        ->where('user_id', $token_data['uuid']) 
        ->first();

        $address->update([
            "country" => $request->country ?? $address->country,
            "city" => $request->city ?? $address->city,
            "zip_code" => $request->zip_code ?? $address->zip_code,
            "address" => $request->address ?? $address->address,
        ]);
        
        return  response()->json($address);

    }
}
