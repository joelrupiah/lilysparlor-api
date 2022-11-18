<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setProductAttribute($value)
    {
        $this->attributes['product'] = serialize($value);
    }

    public function getProductAttribute($value)
    {
        return unserialize($value);
    }

    public function setServiceAttribute($value)
    {
        $this->attributes['service'] = serialize($value);
    }

    public function getServiceAttribute($value)
    {
        return unserialize($value);
    }

    public function getShippingAttribute($value)
    {
        $this->attributes['shipping'] = serialize($value);
    }

    public function setShippingAttribute($value)
    {
        return unserialize($value);
    }
}
