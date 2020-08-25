<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index (){
        $businesses = Business::all();
//        $businesses =array();

//        dd($businesses);

        return view('business.index', compact('businesses'));

    }
}
