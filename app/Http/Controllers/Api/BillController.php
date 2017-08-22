<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\BillRepository;
use App\Contracts\Repositories\BillItemRepository;
use App\Contracts\Repositories\UserRepository;
use App\Contracts\Repositories\OrderBookingRepository;
use App\Contracts\Repositories\MediaRepository;
use App\Http\Controllers\Controller;
use App\Eloquents\Bill;
use App\Eloquents\User;
use App\Eloquents\OrderBooking;
use App\Eloquents\Media;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Helper;
use Validator;
use Response;
use Auth;
use DB;

class BillController extends Controller
{

    protected $bill, $billItem, $user, $orderBooking;

    public function __construct(
        BillRepository $bill,
        BillItemRepository $billItem,
        UserRepository $user,
        OrderBookingRepository $orderBooking
    ) {
        $this->bill = $bill;
        $this->billItem = $billItem;
        $this->user = $user;
        $this->orderBooking = $orderBooking;
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

        $response['data'] = Helper::reFormatPaginate($billByCustomerId);
        
        return Response::json($response);
    }

    public function getBillByCusIdWithImages(Request $request)
    {
        $response = Helper::apiFormat();

        $billByCustomerId = $this->bill->getBillByCustomerIdWithImage($request->customer_id, ['*'], []);

        if ($billByCustomerId->count() == 0)
        {
            $response['error'] = true;
            $response['message'][] = __("There's no bill belong to this customer");

            return Response::json($response);
        }

        foreach ($billByCustomerId as $value)
        {
            $value->bookings = $this->orderBooking->find($value->order_booking_id, 'Images', ['*'] );
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
            'phone' => 'required|numeric|digits_between:6,25',
            'customer_name' => 'required|string|max:255',
            'department_id' => 'required',
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

        // Create user if not exits phone
        $findUser = $this->user->findByPhone($request->phone);
        $customer_id = null;
        if (!$findUser) {
            for($number = 1; $number < 10000; $number++) {
                $email = 'email.' . $request->phone . '.' . $number . '@gmail.com';
                $existUser = $this->user->existEmailOrPhone($email, $request->phone);
                if (!$existUser) {
                    $user = [
                        'email' => $email,
                        'phone' => $request->phone,
                        'name' => $request->customer_name,
                        'password' => $request->phone,
                    ];
                    $newUser = $this->user->create($user);
                    $customer_id = $newUser->id;
                    break;
                }
            }
        } else {
            $customer_id = $findUser->id;
        }
        // End Create User

        DB::beginTransaction();
        try {
            $dataBill = $request->all();
            $billItems = json_decode($request->bill_items, true);
            $dataBill['service_total'] = count($billItems);
            if (!$request->customer_id) {
                $dataBill['customer_id'] = $customer_id;
            }

            $bill = $this->bill->create($dataBill);

            // Xu ly Complete Booking neu complete bill
            $orderBooking = $this->orderBooking->find($request->order_booking_id);
            if ($orderBooking && $bill->status == Bill::STATUS_COMPLETE) {
                $orderBooking->status = OrderBooking::STATUS_FINISHED;
                $orderBooking->save();
            }
            // End

            // Create Bill Item
            foreach ($billItems as $billItem) {
                $billItem['bill_id'] = $bill->id;
                $this->billItem->create($billItem);
            }
            $response['error'] = false;
            $response['status'] = 200;
            $response['data'] = $this->bill->find($bill->id, ['BillItems', 'BillItems.ServiceProduct', 'BillItems.Stylist', 'Department']);
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
        $response = Helper::apiFormat();

        $bill_by_bill_id = $this->bill->find($id, ['BillItems', 'BillItems.ServiceProduct', 'BillItems.Stylist', 'Department']);
        
        if (!$bill_by_bill_id) {
            $response['error'] = true;
            $response['status'] = 404;
            $response['message'][] = __("There's no bill belong to this bill id");
        } else {
            $response['data'] = $bill_by_bill_id;
        }

        return Response::json($response);
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

        $rule = [
            'phone' => 'required|numeric|digits_between:6,25',
            'customer_name' => 'required|string|max:255',
            'department_id' => 'required',
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

        $bill = $this->bill->find($id);
        if (!$bill) {
            $response['message'][] = __('Bill not found!');

            return Response::json($response, $response['status']);
        }

        DB::beginTransaction();
        try {
            $billItems = json_decode($request->bill_items, true);
            $bill->fill($request->all());
            $bill->service_total = count($billItems);
            $bill->save();

            $itemIds = [];
            $itemColection = $this->billItem->getItemsByBillId($id);
            foreach ($billItems as $billItem) {
                if (isset($billItem['id']) && $billItem['id']) { //Edit Bill Item
                    $itemModel = $this->billItem->find($billItem['id']);
                    $itemModel->fill($billItem)->save();
                    $itemIds[] = $billItem['id'];
                } else {  // Create Bill Item
                    $billItem['bill_id'] = $id;
                    $this->billItem->create($billItem);
                }
            }
            // Delete BillItem
            foreach ($itemColection as $item) {
                if (!in_array($item->id, $itemIds)) {
                    $item->delete();
                }
            }

            // Xu ly Complete Booking neu complete bill
            $orderBooking = $this->orderBooking->find($request->order_booking_id);
            if ($orderBooking && $bill->status == Bill::STATUS_COMPLETE) {
                $orderBooking->status = OrderBooking::STATUS_FINISHED;
                $orderBooking->save();
            }
            // End
            
            $response['error'] = false;
            $response['status'] = 200;
            $response['data'] = $this->bill->find($bill->id, ['BillItems', 'BillItems.ServiceProduct', 'BillItems.Stylist', 'Department']);
            $response['message'][] = __('Edit bill successfully!');
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filterBill(Request $request)
    {
        $response = Helper::apiFormat();

        $startDate = Carbon::today()->format('Y-m-d H:i:s');
        $endDate = Carbon::now()->endOfDay();

        $filter_type = $request->type;//today - day - space //default today
        $filter_department = $request->department_id;
        $filter_customer = $request->customer_id;

        $date_start = Carbon::createFromTimestamp($request->start_date);
        $date_end = Carbon::createFromTimestamp($request->end_date);
        switch ($filter_type) {
            case 'day':
                $startDate = $date_start->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $date_start->endOfDay();
                break;
            case 'space':
                $startDate = $date_start->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $date_end->endOfDay();
                break;
        }

        $filter_status = $request->status; //cancel - finished - pending
        if (null !== $filter_status) {
            $filter_status = explode(',', $filter_status);
        }

        $filter = [
            'status' => $filter_status,
            'department_id' => $filter_department,
            'customer_id' => $filter_customer,
        ];
        $currentDate = Carbon::now()->timestamp(strtotime($startDate));
        $responseData = [];

        for (;$currentDate->lte($endDate);) {
            if ($currentDate->gt($endDate)) {
                break;
            }
            $data['date'] = $currentDate->format(config('default.format_date'));
            $date_filter = $currentDate->format('Y-m-d');

            $data['list_bill'] = $this->bill
                ->getFilterBillByDate($date_filter, $filter, ['*'], ['BillItems', 'BillItems.ServiceProduct', 'BillItems.Stylist', 'Department']);
            $responseData[] = $data;
            $currentDate->addDay(1);
            // dd($responseData);
        }
        $response['data'] = $responseData;

        return Response::json($response, $response['status']);
    }
}
