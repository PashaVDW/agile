<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $welkomsbericht = "Welkom bij studievereniging Concat";
        return view('home', compact('welkomsbericht'));
    }
}
