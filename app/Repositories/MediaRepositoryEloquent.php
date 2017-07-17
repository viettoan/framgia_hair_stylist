<?php

namespace App\Repositories;

use App\Contracts\Repositories\MediaRepository;
use App\Eloquents\Media;

class MediaRepositoryEloquent extends AbstractRepositoryEloquent implements MediaRepository
{
    public function model()
    {
        return new Media;
    }
}
