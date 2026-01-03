<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class whole extends Controller
{
     // === HOME PAGE ===
    public function Home()
    {
        return view('home');
    }
}
