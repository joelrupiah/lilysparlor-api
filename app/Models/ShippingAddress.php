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
        'phone',
        'description',
        'expected_date',
        'expected_time',
    ];

    protected $casts = [
        'expected_date' => 'datetime',
        'expected_time' => 'datetime',
    ];

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
