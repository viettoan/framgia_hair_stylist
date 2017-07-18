<?php

namespace App\Eloquents\Relations;

use App\Eloquents\OrderBooking;
use App\Eloquents\ServiceProduct;

trait DepartmentDayoffRelations
{
    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_id');
    }
    
    public function getServiceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }
}
