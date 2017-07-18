<?php

namespace App\Eloquents\Relations;

use App\Eloquents\User;

trait TimeSheetStylistRelations
{
    public function getUser()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }
}
