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

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'banner_assets');
    }
}
