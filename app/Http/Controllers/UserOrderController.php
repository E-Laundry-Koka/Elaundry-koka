<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index() 
    {
        return view('user.form_pemesanan');
    }
}
