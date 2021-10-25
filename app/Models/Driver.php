<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'client_id',
        // 'name',
        // 'email',
        // 'address',
        // 'phone'
    ];
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }

}
