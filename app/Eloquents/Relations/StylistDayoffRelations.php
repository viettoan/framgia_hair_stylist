<?php

namespace App\Eloquents\Relations;

use App\Eloquents\User;

trait StylistDayoffRelations
{
    public function getUser()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
