<?php

namespace App\Eloquent\Relations;

use App\Eloquent\User;

trait StylistDayoffRelations
{
    public function getUser()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
