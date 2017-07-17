<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    use ServiceProductRelations;

    protected $fillable = [
        'id',
        'name',
        'short_description',
        'description',
        'price',
        'avg_rate',
        'total_rate',
    ];
}
