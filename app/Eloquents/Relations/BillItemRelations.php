<?php

namespace App\Eloquents\Relations;

use App\Eloquents\Bill;
use App\Eloquents\SerViceProduct;
use App\Eloquents\User;

trait BillItemRelations
{
    public function getBill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function getServiceProduct()
    {
        return $this->belongsTo(SerViceProduct::class, 'service_product_id');
    }

    public function getStylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
