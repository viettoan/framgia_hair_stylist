<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use App\Eloquents\User;
use Response;
use Validator;
use Auth;

class AdminController extends Controller
{
    protected $user;
    protected $department;
    protected  $selectCustomer = [
        'id',
        'name',
        'email',
        'phone',
        'birthday',
        'avatar',
        'gender',
        'permission',
        'about_me',
        'department_id',
        'created_at',
        'updated_at',
    ];

    public function __construct(
        UserRepository $user,
        DepartmentRepository $department
    ) {
        $this->user = $user;
        $this->department = $department;
    }

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
    
    public function profile($id)
    {
        $user = $this->user->find($id);
        
        return view('admin._component.profile', compact('user'));
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

