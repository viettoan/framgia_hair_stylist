<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use App\Eloquents\Relations\MediaRelations;

class Media extends Model
{
    use MediaRelations;
    
    protected $fillable = [
        'path_origin',
        'path_thumb',
        'media_table_id',
        'media_table_type',
    ];
}
