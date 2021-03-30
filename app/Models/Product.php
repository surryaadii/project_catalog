<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends BaseModel implements TranslatableContract
{
    use Sluggable, Translatable;

    public $timestamps = false;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = [
        'category_id', 'slug'
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function assets()
    {
        return $this->belongsToMany(Asset::class, 'product_assets');
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
