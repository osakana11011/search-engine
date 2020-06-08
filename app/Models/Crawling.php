<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crawling extends Model
{
    const BEFORE_CRAWLING = 0;
    const UNDER_CRAWLING = 1;
    const AFTER_CRAWLING = 2;
    const CANCELED = 3;

    protected $guarded = [
        'id',
        'created_at',
        'deleted_at',
    ];
}
