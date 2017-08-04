<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function home()
    {
        return view('admin._component.home');
    } 

    public function manager_customer()
    {
        return view('admin._component.manager_customer');
    }

    public function manager_booking()
    {
        return view('admin._component.manager_booking');
    }
    
    public function profile()
    {
        return view('admin._component.profile');
    }

    public function bill()
    {
        return view('admin._component.bill');
    }

    public function manager_service()
    {
        return view('admin._component.manage_service');
    }

    public function list_bill()
    {
        return view('admin._component.manager_bill');
    }

    public function manager_department()
    {
        return view('admin._component.manager_department');
    }
}

