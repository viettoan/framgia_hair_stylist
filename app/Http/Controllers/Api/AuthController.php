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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|min:6',
            'password' => 'required|string|min:6|confirmed',
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

        $existUser = $this->user->findByEmail($request->email);
        if ($existUser) {
            $data['error'] = true;
            $response['status'] = 403;
            $data['message']['email'] = __('This email exits!');

            return Response::json($data, 403);
        }

        $this->user->create($request->all());
        $user = $this->user->findByEmail($request->email);
        $response['data']['user'] = $user;

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
        $response['data']['token'] = json_decode(Route::dispatch($proxy)->getContent());

        return Response::json($response, 200);
    }

    public function login(Request $request)
    {
        $response = Helper::apiFormat();

        $rule = [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
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

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = __('Email or password not correct!');

            return Response::json($response, 403);
        }

        $response['data']['user'] = $this->user->findByEmail($request->email);

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
        $response['data']['token'] = json_decode(Route::dispatch($proxy)->getContent());

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
                $response['message'][$key] = $validator->messages()->first($key);
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
