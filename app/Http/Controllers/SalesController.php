<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index(){
        $sale = Sale::select('a.price','a.discount','a.created_at','c.name','c.lastname','b.name as product')
            ->from('sales_detail as a')
            ->join('products as b','b.id','=','a.id_product')
            ->join('customers as c','c.id','=','a.id_customer')
            ->get();
        return Inertia::render('Sales/index', ['sales' => $sale]);
    }

}
