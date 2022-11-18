<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'country',
        'county',
        'postCode',
        'phone',
        'description',
        'expected_date',
        'booking_date'
    ];

    protected $casts = [
        'expected_date' => 'datetime',
        'booking_date' => 'datetime'
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
