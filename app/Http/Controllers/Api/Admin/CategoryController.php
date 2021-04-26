<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Http\Requests\Api\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $total = Category::whereNull('parent_id')->count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];

        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];

        
        if ($search) {
            $q = '%'.$search.'%';
            $query = Category::whereNull('parent_id')->whereTranslationIlike('name', $q)->orderByTranslationOrModel($orderColumn, $orderDir);
            $filtered = $query->count();
            $categories = $query->offset($start)->limit($length)->get();
        } else {
            $categories = Category::whereNull('parent_id')->orderByTranslationOrModel($orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'created_at' => $category->created_at,
            ];
        }
        return response()->json([
            'search' => $search,
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = new Category;
            
            $data = [];
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['name'] = $request->get($locale. '_name');
                $data[$locale]['description'] = $request->get($locale. '_description');
            }
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Category Success Created";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Category not Created';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ], $code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = Category::findOrFail($id);
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['name'] = $request->get($locale. '_name');
                $data[$locale]['description'] = $request->get($locale. '_description');
            }
            if($model->fill($data) && $model->save()) {
                $dataNewModel = [];
                $appLocale = \App::getLocale();
                if($request->get($appLocale .'_sub_category_name') && count($request->get($appLocale .'_sub_category_name'))) {
                    foreach ($request->get($locale .'_sub_category_name') as $key => $val) {
                        $newModel = new Category;
                        $dataNewModel = [];
                        $dataNewModel = [
                            'parent_id' => $model->getKey(),
                        ];
                        foreach (config('translatable.locales') as $locale) {
                            $dataNewModel[$locale]['name'] = $request->get($locale .'_sub_category_name')[$key];
                        }
                        $dataNewModel;
                        $newModel->fill($dataNewModel);
                        $newModel->save();
                    }
                }
                
                \DB::commit();
                $msg = "Category Success Edited";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Category not Edited';
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ], $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {
            $model = Category::with('childrenRecursive')->findOrFail($id);
            $toArrayModel = $model->toArray();
            if(count($toArrayModel['children_recursive'])) {
                $idsChildren = [];
                foreach ($toArrayModel['children_recursive'] as $key => $children) {
                    $idsChildren[] = $children['id'];
                }
                Category::destroy($idsChildren);
            }
            $model->delete();
            \DB::commit();
            $msg = "Category Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Category not Deleted';
        }
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => [
                'message'=>$msg,
            ],
            'time' => microtime(true) - $sTime
        ], $code);
    }
}
