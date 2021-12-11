<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'image',
        'description'
    ];

    //if do not want to disclose some field
    // protected $hidden = [
    //     'id',
    // ];
}
