<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function tour()
    {
        return view('tour');
    }

    public function hot()
    {
        return view('hot');
    }

    public function aboutus()
    {
        return view('aboutus');
    }

    public function reviews()
    {
        return view('reviews');
    }

    public function contact()
    {
        return view('contact');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function marsNaAltae()
    {
        return view('mars-na-altae');
    }

    public function vDolinuChulishman()
    {
        return view('v-dolinu-chulishman-urochishu-ak-kurum');
    }

    public function goriAltaya()
    {
        return view('gori-altaya');
    }
}
