<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class BillController extends Controller
{
    public function exportBill($id)
    {
        $proxy = Request::create('/api/v0/bill/' . $id, 'get');
        $respone = \Route::dispatch($proxy)->getContent();
        $dataBill = json_decode($respone);
        $pdf = PDF::loadView('admin._component.bill', ['dataBill' => $dataBill->data]);

        return $pdf->download($dataBill->data->id . '_' . $dataBill->data->department->name . '_invoice.pdf');
    }
}
