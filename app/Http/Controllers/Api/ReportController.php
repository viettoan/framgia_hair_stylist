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
use DB;

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
        $filter_status = $request->status; //cancel - complete - pending
        
        $statistical = [];
        $total_sales = 0;
        switch ($filter_type) {
            case 'year':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfYear();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfYear();

                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getBillByYear($date_start->format('Y'), $filter_status);
                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $date_start->format('Y'),
                        'value' => $sales,
                    ];
                    $date_start->addYear(1);
                }
                break;
            case 'month':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfMonth();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfMonth();
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill
                        ->getBillByMonth($date_start->format('m'), $date_start->format('Y'), $filter_status);
                    if (null != $filter_status) {
                        $sales = $billCollection->sum('grand_total');
                    } else {
                        $sales = $billCollection->where('status', Bill::STATUS_COMPLETE)->sum('grand_total');
                    }
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $date_start->format('m-Y'),
                        'value' => $sales,
                    ];
                    $date_start->addMonth(1);
                }
                break;
            default:
            // case 'space':
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
                        'label' => $date_start->format(config('default.format_date')),
                        'value' => $sales,
                    ];
                    $date_start->addDay(1);
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
        $response = Helper::apiFormat();

        $filter_type = $request->type;//day - month - year - space //default day
        $filter_number = (int) $request->number_column ?: config('model.bill.number_column'); 
            // So ngay du lieu tra ve
        $filter_status = $request->status; //cancel - complete - pending

        $statistical = [];
        $total_sales = 0;
        switch ($filter_type) {
            case 'year':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfYear();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfYear();

                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getBillByYear($date_start->format('Y'), $filter_status);

                    $sales = $billCollection->count();
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $date_start->format('Y'),
                        'value' => $sales,
                    ];
                    $date_start->addYear(1);
                }
                break;
            case 'month':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfMonth();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfMonth();
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill
                        ->getBillByMonth($date_start->format('m'), $date_start->format('Y'), $filter_status);
                    $sales = $billCollection->count();
                    $total_sales += $sales;
                    $statistical[] = [
                        'label' => $date_start->format('m-Y'),
                        'value' => $sales,
                    ];
                    $date_start->addMonth(1);
                }
                break;
            default:
            // case 'space':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date);
                $date_end = Carbon::createFromTimestamp((int) $request->end_date);
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getBillByDate($date_start->format('Y-m-d'), $filter_status);

                    $sales = $billCollection->count();
                    $total_sales += $sales;

                    $statistical[] = [
                        'label' => $date_start->format(config('default.format_date')),
                        'value' => $sales,
                    ];
                    $date_start->addDay(1);
                }
                break;
        }

        $response['data'] = [
            'statistical' => $statistical,
            'total_bill' => $total_sales,
        ];

        return Response::json($response, $response['status']);
    }

    public function reportCustomer(Request $request)
    {
        $response = Helper::apiFormat();

        $filter_type = $request->type;//day - month - year - space //default day
        $filter_status = $request->status; //cancel - complete - pending
        $select = ['phone', DB::raw('COUNT(id) as count')];

        $statistical = [];
        $customerPhones = [];
        switch ($filter_type) {
            case 'year':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfYear();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfYear();

                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getGroupBillByYear($date_start->format('Y'), $select);

                    $statistical[] = [
                        'label' => $date_start->format('Y'),
                        'value' => $billCollection->count(),
                    ];
                    foreach ($billCollection as $value) {
                        $customerPhones[$value->phone] = $value->phone;
                    }
                    $date_start->addYear(1);
                }
                break;
            case 'month':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date)->startOfMonth();
                $date_end = Carbon::createFromTimestamp((int) $request->end_date)->endOfMonth();
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill
                        ->getGroupBillByMonth($date_start->format('m'), $date_start->format('Y'), $select);
                    $statistical[] = [
                        'label' => $date_start->format('m-Y'),
                        'value' => $billCollection->count(),
                    ];
                    foreach ($billCollection as $value) {
                        $customerPhones[$value->phone] = $value->phone;
                    }
                    $date_start->addMonth(1);
                }
                break;
            default:
            // case 'space':
                $date_start = Carbon::createFromTimestamp((int) $request->start_date);
                $date_end = Carbon::createFromTimestamp((int) $request->end_date);
                while ($date_start->lte($date_end)) {
                    $billCollection = $this->bill->getGroupBillByDate($date_start->format('Y-m-d'), $select);
                    $statistical[] = [
                        'label' => $date_start->format(config('default.format_date')),
                        'value' => $billCollection->count(),
                    ];
                    foreach ($billCollection as $value) {
                        $customerPhones[$value->phone] = $value->phone;
                    }
                    $date_start->addDay(1);
                }
                break;
        }
        
        $customer_old = 0;
        $customer_new = 0;
        foreach ($customerPhones as $customerPhone) {
            if ($this->bill->countBillByPhone($customerPhone) > 1) {
                $customer_old += 1;
            } else {
                $customer_new += 1;
            }
        }

        $response['data'] = [
            'statistical' => $statistical,
            'customer_new' => $customer_new,
            'customer_old' => $customer_old,
        ];

        return Response::json($response, $response['status']);
    }
}
