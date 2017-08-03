<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use Validator;
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

    public function createDepartment(Request $request)
    {
        $response = Helper::apiFormat();

        $rule = [
            'department_name' => 'required|string',
            'department_address' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                $response['message'][$key] = $validator->messages()->first($key);
            }

            return Response::json($response, 403);
        }
        $getDepartment = $this->department
            ->getDepartmentByAdress($request->department_address);

        if($getDepartment && $request->department_address == $getDepartment->address)
        {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'] = __('This department already exist!');

            return Response::json($response, 403);
        }

        $departmentData = [
            'name' => $request->department_name,
            'address' => $request->department_address,
        ];

        $departmentCreated = $this->department->create($departmentData);

        $response['data'] = $this->department->find($departmentCreated->id);

        return Response::json($response);
    }
}
