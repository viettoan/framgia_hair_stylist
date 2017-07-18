<?php

namespace App\Eloquents\Relations;

trait MediaRelations
{
    public function mediaTable()
    {
        return $this->morphTo();
    }
}
