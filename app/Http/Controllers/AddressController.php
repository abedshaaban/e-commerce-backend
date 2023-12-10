<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
}
