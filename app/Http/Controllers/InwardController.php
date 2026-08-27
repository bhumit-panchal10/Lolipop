<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inward;

class InwardController extends Controller
{
    public function index(Request $request)
    {
        return view('product.inward');
    }
}
