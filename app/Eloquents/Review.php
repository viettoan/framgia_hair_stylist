<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'point_rate',
        'title',
        'content',
        'review_table_id',
        'review_table_type',
        'status',
    ];
}
