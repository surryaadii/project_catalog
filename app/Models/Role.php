<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel
{
    public $timestamps = false;
    //
    protected $fillable = [
        'name'
    ];
}
