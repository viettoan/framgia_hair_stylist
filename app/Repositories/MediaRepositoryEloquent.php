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

    public function getLastImage($id, $type)
    {
    	return $this->model()->where('media_table_id', $id)->where('media_table_type', $type)->last();
    }
}
