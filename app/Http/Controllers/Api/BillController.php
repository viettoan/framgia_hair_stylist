<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\Repositories\BillRepository;
use App\Helpers\Helper;
use App\Eloquents\Bill;
use Response;

class BillController extends Controller
{
    protected $Bill;

    public function __construct( BillRepository $Bill) 
    {
        $this->Bill = $Bill;
    }

    public function getBillByCustomerId(Request $request)
    {
        $response = Helper::apiFormat();
        $perPage = $request->per_page ?: config('model.booking.default_filter_limit');

        $billByCustomerId = $this->Bill->getBillByCustomerId($request->customer_id, $perPage, 'getAllBillItems');
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
}
