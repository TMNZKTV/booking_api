<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    // Для предыдущего рабочего решения
    // public function index() {
    //     return view('index');
    // }
    
    public function __invoke() {
        return view('index');
    }
}

