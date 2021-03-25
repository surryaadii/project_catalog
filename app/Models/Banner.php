<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends BaseModel
{
    public $timestamps = false;
    //
    protected $fillable = [
        'key', 'banner_page'
    ];
}
