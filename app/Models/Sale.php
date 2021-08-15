<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales_detail';
    protected $fillable = [
      'id_customer',
      'id_product',
      'quantity',
      'price',
      'discount',
    ];
}
