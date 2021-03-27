<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Product;
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get()->toArray();
        $dataCategories = [];
        foreach ($categories as $key => $category) {
            $dataSubCategories = [];
            if(count($category['children_recursive'])) {
                foreach ($category['children_recursive'] as $key => $children) {
                    $dataSubCategories[$children['id']] = $children['name'];
                }
            } 
            $dataCategories[count($dataSubCategories) ? $category['name'] : $category['id']] = count($dataSubCategories) ? $dataSubCategories : $category['name'];
        }
        // dd($dataCategories);
        return view('admin.product.create', compact('model', 'dataCategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Product::findOrFail($id);
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->get()->toArray();
        $dataCategories = [];
        foreach ($categories as $key => $category) {
            $dataSubCategories = [];
            if(count($category['children_recursive'])) {
                foreach ($category['children_recursive'] as $key => $children) {
                    $dataSubCategories[$children['id']] = $children['name'];
                }
            } 
            $dataCategories[count($dataSubCategories) ? $category['name'] : $category['id']] = count($dataSubCategories) ? $dataSubCategories : $category['name'];
        }
        return view('admin.product.edit', compact('model', 'dataCategories'));
    }
}
