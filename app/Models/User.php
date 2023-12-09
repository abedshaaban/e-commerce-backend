<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;



class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'uuid';
    public $timestamps = false;

    protected $fillable = ['uuid', 'email', 'password', 'f_name', 'l_name', 'role_id'];

    protected $hidden = ['remember_token'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email'=>$this->email,
            'password'=>$this->password,
            'f_name'=>$this->f_name,
            'l_name'=>$this->l_name,

        ];
    }
}
