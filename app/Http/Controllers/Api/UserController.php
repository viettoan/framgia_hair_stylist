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
use Auth;

class UserController extends Controller
{
    protected $user;
    protected $department;

    public function __construct(
        UserRepository $user,
        DepartmentRepository $department
    ) {
        $this->user = $user;
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

        $stylist = $this->user->getStylistByDepartmentId($departmentId);
        if ($stylist->count() == 0) {
            $response['message'] = __('Currently this Department have no stylist');
        }
        $response['data'] = $stylist;

        return Response::json($response) ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Helper::apiFormat();

        // Check permission User
        $user = Auth::guard('api')->user();
        if (!$user || $user->permission != User::PERMISSION_ADMIN) {
            $response['error'] = true;
            $response['message'][] = __('You do not have permission to perform this action!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $rule = [
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:6',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];

        $response['error'] = true;
        $response['status'] = 403;
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }

        $existUser = $this->user->existEmailOrPhone($request->email, $request->phone);
        if ($existUser) {
            $response['message'][] = __('This email or phone number exits!');

            return Response::json($response, $response['status']);
        }

        $user = $this->user->create($request->all());
        $response['error'] = false;
        $response['status'] = 200;
        $response['message'][] = __('Create user successfully!');

        return Response::json($response, $response['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Helper::apiFormat();

        $user = $this->user->find($id);
        if (!$user) {
            $response['error'] = true;
            $response['message'][] = __('Not found user!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $response['data'] = $user;

        return Response::json($response, $response['status']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = Helper::apiFormat();

        // Check permission User
        $user = Auth::guard('api')->user();
        if (!$user || $user->permission != User::PERMISSION_ADMIN) {
            $response['error'] = true;
            $response['message'][] = __('You do not have permission to perform this action!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $user = $this->user->find($id);
        if (!$user) {
            $response['error'] = true;
            $response['message'][] = __('Not found user!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $rule = [
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:6',
            'name' => 'required|string|max:255',
            'password' => 'string|min:6|confirmed',
        ];

        $response['error'] = true;
        $response['status'] = 403;
        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }

        $userEmail = $this->user->findByEmailOrPhone($request->email);
        $userPhone = $this->user->findByEmailOrPhone($request->phone);
        if (($userEmail && $userEmail->id != $id)
            || ($userPhone && $userPhone->id != $id)
        ){
            $response['message'][] = __('This email or phone number exits!');

            return Response::json($response, $response['status']);
        }

        $user->fill($request->all())->save();
        $response['error'] = false;
        $response['status'] = 200;
        $response['message'][] = __('Update user successfully!');

        return Response::json($response, $response['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getByPhone(Request $request)
    {
        $response = Helper::apiFormat();

        $user = $this->user->findByEmailOrPhone($request->phone);
        if (!$user) {
            $response['error'] = true;
            $response['message'][] = __('Not found user!');
            $response['status'] = 403;

            return Response::json($response, $response['status']);
        }

        $response['data'] = $user;

        return Response::json($response, $response['status']);
    }

    public function getAllCustommerByPage(Request $request)
    {
        $response = Helper::apiFormat();
        $per_page = $request->per_page ? : config('model.custommer.default_filter_limit');
        
        $select = [
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

        $custommer = $this->user->getAllCustommer($per_page, [], $select);
        $response['data'] = $custommer;

        return Response::json($response);
    }
}
