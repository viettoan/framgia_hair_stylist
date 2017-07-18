<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\DepartmentRelations;

class Department extends Model
{
    use DepartmentRelations;

    protected $fillable = [
        'name',
        'address',
    ];
}
