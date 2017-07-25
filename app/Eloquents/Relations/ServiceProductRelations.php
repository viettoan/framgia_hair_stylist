<?php

namespace App\Eloquents\Relations;

use App\Eloquents\OrderItem;
use App\Eloquents\BillItem;

trait ServiceProductRelations
{
    public function getOrderItem()
    {
        return $this->hasMany(OrderItem::class, 'service_product_id');
    }

    public function getBillItem()
    {
        return $this->hasMany(BillItem::class, 'service_product_id');
    }

}
