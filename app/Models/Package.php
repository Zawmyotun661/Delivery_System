<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    
    use HasFactory;
    protected $table = 'packages';
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d ');
    }
    protected $fillable = [
        'client_id',
        'shopper_id',
        'date',
        'package_name',
        'package_size',
        'receiver_name',
        'phone',
        'address',
        'township_id',
        'price',
        'paid_amount',
        'delivery_fee',
        'status',
        'image',
        'remark',
        'payment_status',
        'driver_id',
        'paid',
      
    ];
    
}
