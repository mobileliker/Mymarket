<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{


    public function index($id)
    {
        
        return view('szy.shop', compact(''));
    }

}
