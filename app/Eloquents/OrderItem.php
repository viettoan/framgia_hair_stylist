<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use OrderItemRelations;

    protected $fillable = [
        'id',
        'order_id',
        'service_product_id',
        'price',
        'service_name',
    ];
}
