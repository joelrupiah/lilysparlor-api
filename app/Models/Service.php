<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'slug',
      'price',
      'description',
      'mainDescription',
      'imageOne',
      'imageTwo',
      'imageThree'
    ];

    public function getImageAttribute($value){
        return 'http://127.0.0.1:8000/uploads/images/service/'.$value;
    }
}
