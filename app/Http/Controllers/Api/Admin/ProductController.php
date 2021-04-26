<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Api\ProductRequest;
use App\Models\Product;
use App\Models\Asset;

class ProductController extends Controller
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
        $total = Product::count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];

        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];

        
        if ($search) {
            $q = '%'.$search.'%';
            $query = Product::whereTranslation('name', 'ilike', $q)->orderByTranslationOrModel($orderColumn, $orderDir);
            $filtered = $query->count();
            $products = $query->offset($start)->limit($length)->get();
        } else {
            $products = Product::orderByTranslationOrModel($orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'created_at' => $product->created_at
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
    public function store(ProductRequest $request)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = new Product;
            
            $data = [
                'category_id' => $request->get('category_id')
            ];
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['name'] = $request->get($locale. '_name');
                $data[$locale]['description'] = $request->get($locale. '_description');
            }
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Product Success Created";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Product not Created';
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = Product::findOrfail($id);
            $data = [
                'category_id' => $request->get('category_id')
            ];
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['name'] = $request->get($locale. '_name');
                $data[$locale]['description'] = $request->get($locale. '_description');
            }
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Product Success Edited";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Product not Edited';
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
            $model = Product::findOrFail($id);
            $model->delete();
            \DB::commit();
            $msg = "Product Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Product not Deleted';
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

    public function indexProductAssets(Request $request, $id)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $total = Product::findOrFail($id)->assets()->count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];
        //
        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];
        
        //
        
        if ($search) {
            $q = '%'.$search.'%';
            $query = Product::findOrFail($id)->assets()->where('name', 'ilike', $q)->orderBy('assets.'.$orderColumn, $orderDir);
            $filtered = $query->count();
            $product_assets = $query->offset($start)->limit($length)->get();
        } else {
            $product_assets = Product::findOrFail($id)->assets()->orderBy('assets.'.$orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        
        foreach($product_assets as $asset) {
            $data[] = [
                'id' => $asset->id,
                'name' => $asset->name,
                'size' => $asset->size,
                'mime_type' => $asset->mime_type,
                'created_at' => $asset->created_at,
                'url' => $asset->url()
            ];
        }
      
      return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $total,
        'recordsFiltered' => $filtered,
        'data' => $data,
      ]);
    }

    public function addAssets(Request $request, $id) 
    {
        \DB::beginTransaction();
        $status = false;
        $code = 400;
        $message = '';
        $sTime = microtime(true);
        try {
            $product = Product::findOrFail($id);
            
            $asset = new Asset;
            $asset->name = $request->file->getClientOriginalName();
            $asset->extension = $request->file->extension();
            $asset->mime_type = $request->file->getClientMimeType();
            $asset->size = $request->file->getSize();
            $asset->save();

            $product->assets()->attach($asset);
        
            $path = $asset->create_path( $asset->created_at, $asset->id );
        
            $request->file->storeAs(
                $path,
                $asset->name
            );
            $asset->generates();
            \DB::commit();
            $msg = "Product Asset Success Uploaded";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th){
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Product Asset not Uploaded';
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

    public function deleteAssetProduct($idProduct, $idAsset) {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {
            $product = Product::findOrFail($idProduct);
            $assetQuery = $product->assets()->where('asset_id', $idAsset);
            $asset = $assetQuery->first();
            $assetQuery->delete(); 
            $path = $asset->create_path( $asset->created_at, $asset->id );
            Storage::delete( $path . '/' . $asset->name );
            Storage::deleteDirectory( $path );
            \DB::commit();
            $msg = "Product Asset Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Product Asset not Deleted';
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
