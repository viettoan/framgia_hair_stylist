<?php

namespace App\Eloquent\Relations;

trait MediaRelations
{
    public function mediaTable()
    {
        return $this->morphTo();
    }
}
