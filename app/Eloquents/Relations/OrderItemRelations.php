<?php

namespace App\Eloquents\Relations;

use App\Eloquents\OrderBooking;
use App\Eloquents\ServiceProduct;
use App\Eloquents\User;

trait OrderItemRelations
{
    public function getOrderBooking()
    {
        return $this->belongsTo(OrderBooking::class, 'order_booking_id');
    }
    
    public function getServiceProduct()
    {
        return $this->belongsTo(ServiceProduct::class, 'service_product_id');
    }

    public function getStylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
