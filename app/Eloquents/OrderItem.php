<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\OrderItemRelations;

class OrderItem extends Model
{
    use OrderItemRelations;

    protected $fillable = [
        'order_id',
        'service_product_id',
        'price',
        'service_name',
    ];
}
