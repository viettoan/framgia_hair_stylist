<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\DepartmentRepository;
use App\Helpers\Helper;
use App\Eloquents\User;
use Response;
use Validator;

class UserController extends Controller
{
    protected $userRepo;
    protected $department;

    public function __construct(
        UserRepository $userRepo,
        DepartmentRepository $department
    ) {
        $this->userRepo = $userRepo;
        $this->department = $department;
    }

    public function getStylistbySalonID(Request $request, $departmentId)
    {
        $response = Helper::apiFormat();

        $department = $this->department->find($departmentId);
        if (!$department) {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __('This Department does not exists');

            return Response::json($response) ;
        }

        $stylist = $this->userRepo->getStylistByDepartmentId($departmentId);
        if ($stylist->count() == 0) {
            $response['message'] = __('Currently this Department have no stylist');
        }
        $response['data'] = $stylist;

        return Response::json($response) ;
    }
}
