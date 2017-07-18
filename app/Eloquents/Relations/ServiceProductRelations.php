<?php

namespace App\Eloquents\Relations;

use App\Eloquents\OrderItem;

trait ServiceProductRelations
{
    public function getOrderItem()
    {
        return $this->hasMany(OrderItem::class, 'service_product_id');
    }
}
