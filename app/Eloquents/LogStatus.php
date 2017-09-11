<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\LogStatusRelations;

class LogStatus extends Model
{
    use LogStatusRelations;

    protected $table = 'log_status';

    protected $fillable = [
        'order_booking_id',
        'user_id',
        'old_status',
        'new_status',
        'message'
    ];
}
