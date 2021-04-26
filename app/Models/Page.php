<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Page extends BaseModel implements TranslatableContract
{
    use Sluggable, Translatable;

    public $timestamps = false;

    public $translatedAttributes = ['title', 'body'];
    protected $fillable = [
        'slug'
    ];

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'page_assets');
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
