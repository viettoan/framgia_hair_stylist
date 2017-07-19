<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\UserRepository;
use App\Helpers\Helper;
use Response;
use Validator;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getStylistbySalonID(Request $request, $departmentId)
    {
        $response = Helper::apiFormat();

        $data = $this->userRepo->getStylistByDepartmentId([],['*'],'department_id', $departmentId);
        if(empty($data->first()))
        {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'] = [
                'This department does not exists',
            ];
        }

        $response['data'] = $data;

        return Response::json($response) ;
    }
}
