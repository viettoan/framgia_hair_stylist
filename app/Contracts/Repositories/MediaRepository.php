<?php

namespace App\Contracts\Repositories;

interface MediaRepository extends AbstractRepository
{
    function getLastImage($id, $type);
}
