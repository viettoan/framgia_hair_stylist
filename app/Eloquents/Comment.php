<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'content',
        'status',
        'parent_id',
        'comment_table_id',
        'comment_table_type',
    ];
}
