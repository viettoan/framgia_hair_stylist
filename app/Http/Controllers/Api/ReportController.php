<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Repositories\BillRepository;
use App\Contracts\Repositories\BillItemRepository;
use App\Http\Controllers\Controller;
use App\Eloquents\Bill;
use App\Eloquents\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\Helper;
use Validator;
use Response;
use Auth;

class ReportController extends Controller
{
    protected $bill, $billItem;

    public function __construct(
        BillRepository $bill,
        BillItemRepository $billItem
    ) {
        $this->bill = $bill;
        $this->billItem = $billItem;
    }

    public function reportSales(Request $request)
    {
        $response = Helper::apiFormat();

        $filter_type = $request->type;//day - month - year - space //default day
        $filter_number = (int) $request->number_column ?: config('model.bill.number_column'); 
            // So ngay du lieu tra ve
        $filter_status = $request->status; //cancel - complete - pending

        $statistical = [];
        $total_sales = 0;
        switch ($filter_type) {
            case 'year':
                $currentYear = (int) Carbon::now()->format('Y');
                for ($i= $filter_number - 1; $i >= 0 ; $i--) { 
                    $billCollection = $this->bill->getBillByYear($currentYear - $i, $filter_status);
                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $currentYear - $i,
                        'value' => $sales,
                    ];
                }
                break;
            case 'month':
                for ($i= $filter_number - 1; $i >= 0 ; $i--) {
                    $now = Carbon::now()->addMonth(-$i);
                    $billCollection = $this->bill
                        ->getBillByMonth($now->format('m'), $now->format('Y'), $filter_status);
                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $now->format('m-Y'),
                        'value' => $sales,
                    ];
                }
                break;
            case 'space':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date);
                $date_end = Carbon::createFromTimestamp((int) $request->end_date);
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getBillByDate($date_start->format('Y-m-d'), $filter_status);

                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;

                    $statistical[] = [
                        'label' => $date_start->format('d-m-Y'),
                        'value' => $sales,
                    ];
                    $date_start->addDay(1);
                }
                break;
            default:
                for ($i= $filter_number - 1; $i >= 0 ; $i--) {
                    $now = Carbon::now()->addDay(-$i);
                    $billCollection = $this->bill->getBillByDate($now->format('Y-m-d'), $filter_status);

                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $now->format('d-m-Y'),
                        'value' => $sales,
                    ];
                }
                break;
        }

        $response['data'] = [
            'statistical' => $statistical,
            'total_sale' => $total_sales,
        ];

        return Response::json($response, $response['status']);
    }

    public function reportBills(Request $request)
    {
        
    }
}
