<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\BillItemRelations;

class BillItem extends Model
{
    use BillItemRelations;
    
    protected $fillable = [
        'bill_id',
        'service_product_id',
        'stylist_id',
        'service_name',
        'price',
        'discount',
        'row_total',
    ];
}
