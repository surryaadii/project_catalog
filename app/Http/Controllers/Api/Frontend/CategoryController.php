<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends ApiController
{
    public function index() 
    {
        $sTime = microtime(true);
        $status = true;
        $message = '';
        $categories = Category::with('childrenRecursive')
                        ->with(['subProducts.category' => function($q) {
                                // $q->where('categories.id', 47);
                        }])->whereNull('parent_id')->get();

        $data = [];
        if(count($categories)) {
            foreach ($categories as $i => $category) {
                $subCategories = [];
                if(count($category->childrenRecursive)) {
                    foreach ($category->childrenRecursive as $j => $children) {
                        $subCategories[] = [
                            'name' => $children['name'],
                            'slug' => $children['slug'],
                        ];
                    }
                    $data[] = [
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'slug' => $category['slug'],
                        'sub_categories' => $subCategories
                    ];
                }
            }
            $message = 'Categories Success Retrieved';
        } else {
            $message = 'Categories No Data';

        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'values' => [
                'categories'=>$data
            ],
            'time' => microtime(true)-$sTime
        ]);

    }
}
