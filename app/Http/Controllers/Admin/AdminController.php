<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.master');
    } 

    public function manager_customer()
    {
        return view('admin._component.manager_customer');
    }

     public function manager_booking()
    {
        return view('admin._component.manager_booking');
    }
}

