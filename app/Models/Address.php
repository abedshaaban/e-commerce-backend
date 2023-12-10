<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    

    public $timestamps = false;

    protected $fillable = ['id', 'user_id', 'country', 'city', 'zip_code', 'address'];

}
