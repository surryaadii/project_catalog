<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends BaseModel
{
    use sluggable;

    public $timestamps = false;
    //
    protected $fillable = [
        'name', 'parent_id', 'description', 'slug'
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
