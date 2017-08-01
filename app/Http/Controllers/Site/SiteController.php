<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function index()
    {
    	return view('index');
    }

    public function login()
    {
    	return view('sites._component.login');
    }

    public function signup()
    {
    	return view('sites._component.signup');
    }
    
}
