<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Route;
use Response;
use Auth;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function register(Request $request)
    {
        $response = Helper::apiFormat();

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
        $data['user'] = $this->user->findByEmailOrPhone($request->email ?: $request->phone);

        $param = [
            'grant_type' => 'password',
            'client_id' => env('API_PASSWORD_CLIENT_ID'),
            'client_secret' => env('API_PASSWORD_CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ];

        $request->request->add($param);
        $proxy = Request::create('oauth/token', 'POST');
        $data['token'] = json_decode(Route::dispatch($proxy)->getContent());
        $response['data'] = $data;
        $response['error'] = false;
        $response['status'] = 200;

        return Response::json($response, $response['status']);
    }

    public function login(Request $request)
    {
        $response = Helper::apiFormat();

        $rule = [
            'email_or_phone' => 'required|max:255',
            'password' => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, 403);
        }

        if (!Auth::attempt(['email' => $request->email_or_phone, 'password' => $request->password])
            && !Auth::attempt(['phone' => $request->email_or_phone, 'password' => $request->password])
            ) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __('Email, number phone or password not correct!');

            return Response::json($response, 403);
        }

        $data['user'] = $this->user->findByEmailOrPhone($request->email_or_phone);
        $param = [
            'grant_type' => 'password',
            'client_id' => env('API_PASSWORD_CLIENT_ID'),
            'client_secret' => env('API_PASSWORD_CLIENT_SECRET'),
            'username' => $data['user']->email,
            'password' => $request->password,
            'scope' => '*',
        ];

        $request->request->add($param);
        $proxy = Request::create('oauth/token', 'POST');
        $data['token'] = json_decode(Route::dispatch($proxy)->getContent());
        $response['data'] = $data;

        return Response::json($response, 200);
    }

    public function refreshToken(Request $request)
    {
        $response = Helper::apiFormat();

        $rule = [
            'refresh_token' => 'required',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;
            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, 403);
        }

        $param = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => env('API_PASSWORD_CLIENT_ID'),
            'client_secret' => env('API_PASSWORD_CLIENT_SECRET'),
        ];

        $request->request->add($param);
        $proxy = Request::create('oauth/token', 'POST');
        $response['data']['token'] = json_decode(Route::dispatch($proxy)->getContent());

        return Response::json($response, 200);
    }

    public function logout(Request $request)
    {
        $response = Helper::apiFormat();

        $user = Auth::guard('api')->user();
        if (!$user) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __("You don't login or Access token expired!");
        } else {
            $user->token()->revoke();
            $response['message'][] = __('You are Logged out.');
        }
        
        return Response::json($response, $response['status']);
    }
}
