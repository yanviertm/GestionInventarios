<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table    = 'products';
    protected $fillable = [
        'id_category',
        'name',
        'price',
        'description',
        'stock',
        'name_img',
        'url_img',
        'enabled',
        'discount',
    ];
}
