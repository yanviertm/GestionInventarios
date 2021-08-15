<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'lastname',
        'document_type',
        'id_document',
        'email',
        'phone',
        'country',
        'city',
        'address',
        'username',
        'password',
        'enabled',
    ];
}
