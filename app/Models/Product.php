<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'productcls_id',
        'name',
        'slug',
        'sku',
        'price',
        'description',
        'mainDescription',
        'imageOne',
        'imageTwo',
        'imageThree'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function productcls()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getImageAttribute($value){
        return 'http://127.0.0.1:8000/uploads/images/product/'.$value;
    }

}
