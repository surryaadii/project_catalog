<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends BaseModel implements TranslatableContract
{
    use Sluggable, Translatable;

    public $timestamps = false;
    //
    public $translatedAttributes = ['name', 'description'];
    protected $fillable = [
        'parent_id', 'slug'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with(['childrenRecursive']);
    }

    public function products() {
        // return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
        return $this->hasMany(Product::class, 'category_id');
    }

    public function subProducts()
    {
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
    }

    public function sluggable() {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
