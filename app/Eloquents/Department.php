<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use DepartmentRelations;

    protected $fillable = [
        'id',
        'name',
        'address',
    ];
}
