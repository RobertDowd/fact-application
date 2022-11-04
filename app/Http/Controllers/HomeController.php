<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $showSuccessMsg = 'false';
        return view('home', compact('showSuccessMsg'));
    }
}
