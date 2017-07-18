<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'status',
        'parent_id',
    ];
}
