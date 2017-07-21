<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use Response;

class DepartmentsController extends Controller
{
    protected $department;
    protected $selectDepartment = [
        'id',
        'name',
        'address',
    ];

    public function __construct(DepartmentRepository $department)
    {
        $this->department = $department;
    }

    public function index()
    {
        $response = Helper::apiFormat();
        $data = $this->department->getAllData([], $this->selectDepartment);
        
        $response['data'] = $data;

        return Response::json($response) ;
    }
}
