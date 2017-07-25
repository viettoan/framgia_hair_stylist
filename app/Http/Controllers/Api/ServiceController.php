<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\ServiceProductRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Response;

class ServiceController extends Controller
{

    protected $service;

    public function __construct(ServiceProductRepository $service)
    {
        $this->service = $service;
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

        $rule = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
        ];

        // short_description
        // description

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;

            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }

        try {
            $this->service->create($request->all());
            $response['message'][] = __('Create service successfully!');
        } catch (Exception $e) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = $e->getMessage();
        }

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
        //
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

        $service = $this->service->find($id);
        if (!$service) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'] = __('Not found service!');

            return Response::json($response, $response['status']);
        }

        $rule = [
            'name' => 'required|max:255',
            'price' => 'required|numeric',
        ];

        // short_description
        // description

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $response['error'] = true;
            $response['status'] = 403;

            foreach ($rule as $key => $value) {
                if ($validator->messages()->first($key)) {
                    $response['message'][] = $validator->messages()->first($key);
                }
            }

            return Response::json($response, $response['status']);
        }

        try {
            $service->fill($request->all())->save();
            $response['message'][] = __('Updated service successfully!');
        } catch (Exception $e) {
            $response['error'] = true;
            $response['status'] = 403;
            $response['message'][] = $e->getMessage();
        }

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
}
