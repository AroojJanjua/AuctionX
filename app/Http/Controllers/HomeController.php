<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');

    }

    public function howItWorks()
    {
        return view('pages.how-it-works');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }
    public function privacy()
    {
        return view('pages.privacy');
    }
 
    public function terms()
    {
        return view('pages.terms');
    }
 
    public function support()
    {
        return view('pages.support');
    }
}
