<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\ServiceProductRelations;

class ServiceProduct extends Model
{
    use ServiceProductRelations;

    protected $fillable = [
        'name',
        'short_description',
        'description',
        'price',
        'avg_rate',
        'total_rate',
    ];
}
