<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends BaseModel
{
    public $timestamps = false;
    //
    protected $fillable = [
        'name', 'parent_id', 'description'
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
        return $this->children()->with('childrenRecursive');
    }

    public function products() {
        return $this->hasManyThrough(Product::class, Category::class, 'parent_id', 'category_id', 'id');
    }
}
