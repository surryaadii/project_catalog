<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends BaseModel
{
    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'category_id', 'name', 'description', 'slug'
    ];

    public function categories() {
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
