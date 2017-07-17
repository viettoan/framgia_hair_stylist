<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use MediaRelations;
    
    protected $fillable = [
        'id',
        'path_origin',
        'path_thumb',
        'media_table_id',
        'media_table_type',
    ];
}
