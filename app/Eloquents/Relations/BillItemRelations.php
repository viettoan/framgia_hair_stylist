<?php

namespace App\Eloquents\Relations;

use App\Eloquents\Bill;
use App\Eloquents\ServiceProduct;
use App\Eloquents\User;

trait BillItemRelations
{
    public function getBill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function getServiceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }

    public function ServiceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }

    public function getStylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }

    public function Stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
