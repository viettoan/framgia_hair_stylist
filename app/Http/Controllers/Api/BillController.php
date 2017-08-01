<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\BillRepository;
use App\Contracts\Repositories\BillItemRepository;
use App\Http\Controllers\Controller;
use App\Eloquents\Bill;
use App\Eloquents\User;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Validator;
use Response;
use Auth;
use DB;

class BillController extends Controller
{
    protected $bill, $billItem;

    public function __construct(
        BillRepository $bill,
        BillItemRepository $billItem
    ) {
        $this->bill = $bill;
        $this->billItem = $billItem;
    }

    public function getBillByCustomerId(Request $request)
    {
        $response = Helper::apiFormat();
        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

        $billByCustomerId = $this->bill->getBillByCustomerId($request->customer_id, $perPage, 'getAllBillItems');
        if($billByCustomerId->count() == 0)
        {
            $response['error'] = true;
            $response['status'] = '404';
            $response['message'][] = __("There's no bill belong to this customer");

            return Response::json($response);
        }

        $response['data'] = $billByCustomerId;
        
        return Response::json($response);
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

        // customer_id
        // customer_name
        // phone
        // status
        // grand_total
        // order_booking_id
        /** bill_items [
            {
                id: '',
                service_product_id: "1",
                stylist_id: "2",
                service_name: "asdfsadfsd",
                price: "2233423",
                discount: "1245",
                row_total: "123"
            }
        ]
        **/

        $rule = [
            'phone' => 'required|numeric|min:6',
            'customer_name' => 'required|string|max:255',
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

        DB::beginTransaction();
        try {
            $dataBill = $request->all();
            $billItems = json_decode($request->bill_items, true);
            $dataBill['service_total'] = count($billItems);

            $bill = $this->bill->create($request->all());

            // Xu ly Complete Booking

            // Create Bill Item
            foreach ($billItems as $billItem) {
                $billItem['bill_id'] = $bill->id;
                $this->billItem->create($billItem);
            }
            $response['error'] = false;
            $response['data'] = $this->bill->find($bill->id, 'BillItems');
            $response['message'][] = __('Create bill successfully!');
            DB::commit();
            
        } catch (Exception $e) {
            $response['status'] = 403;
            $response['error'] = true;
            $response['message'][] = $e->getMessages();
            DB::rollback();
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
        //
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
