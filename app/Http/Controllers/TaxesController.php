<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\{Taxes};

class TaxesController extends Controller
{
    public function index(){
        return Inertia::render('Taxes/index', ['taxes' => Taxes::all()]);
    }
}
