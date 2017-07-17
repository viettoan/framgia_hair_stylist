<?php

namespace App\Eloquent\Relations;

use App\Eloquent\OrderItem;

trait ServiceProductRelations
{
    public function getOrderItem()
    {
        return $this->hasMany(OrderItem::class, 'service_product_id');
    }
}
