<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_package',
        
    ];
    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
