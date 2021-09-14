<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'country',
        'city',
        'township',
        'email',
        'password',
        'address',
        'phone'
    ];
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];
}
