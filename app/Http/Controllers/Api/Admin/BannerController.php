<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\BannerRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use App\Models\Asset;

class BannerController extends Controller
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
        $total = Banner::count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];

        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];

        
        if ($search) {
            $q = '%'.$search.'%';
            $query = Banner::where('name', 'ilike', $q)->orderBy($orderColumn, $orderDir);
            $banners = $query->offset($start)->limit($length)->get();
            $filtered = $query->count();
        } else {
            $banners = Banner::orderBy($orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        foreach ($banners as $banner) {
            $data[] = [
                'id' => $banner->id,
                'key' => $banner->key,
                'banner_page' => $banner->banner_page,
                'created_at' => $banner->created_at
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = new Banner;
            $key = \Str::slug($request->get('banner_page'), '_');
            $data = [
                'key' => $key,
                'banner_page' => $request->get('banner_page'),
            ];
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Banner Success Saved";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Banner not Created';
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = Banner::findOrFail($id);
            $key = join('_', explode(' ', $request->get('banner_page')));
            $data = [
                'key' => $key,
                'banner_page' => $request->get('banner_page'),
            ];
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Banner Success Saved";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Banner not Created';
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
            $model = Banner::findOrFail($id);
            $model->delete();
            \DB::commit();
            $msg = "Banner Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Banner not Deleted';
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

    public function indexBannerAssets(Request $request, $id)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $total = Banner::findOrFail($id)->assets()->count();
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
            $query = Banner::findOrFail($id)->assets()->where('name', 'ilike', $q)->orderBy('assets.'.$orderColumn, $orderDir);
            $filtered = $query->count();
            $banner_assets = $query->offset($start)->limit($length)->get();
        } else {
            $banner_assets = Banner::findOrFail($id)->assets()->orderBy('assets.'.$orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        
        foreach($banner_assets as $asset) {
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
            $banner = Banner::findOrFail($id);
            
            $asset = new Asset;
            $asset->name = $request->file->getClientOriginalName();
            $asset->extension = $request->file->extension();
            $asset->mime_type = $request->file->getClientMimeType();
            $asset->size = $request->file->getSize();
            $asset->save();

            $banner->assets()->attach($asset);
        
            $path = $asset->create_path( $asset->created_at, $asset->id );
        
            $request->file->storeAs(
                $path,
                $asset->name
            );
            $asset->generates();
            \DB::commit();
            $msg = "Banner assets Success Created";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th){
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Banner assets not Created';
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

    public function deleteAssetBanner($idBanner, $idAsset) {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {
            $banner = Banner::findOrFail($idBanner);
            $assetQuery = $banner->assets()->where('asset_id', $idAsset);
            $asset = $assetQuery->first();
            $assetQuery->delete(); 
            $path = $asset->create_path( $asset->created_at, $asset->id );
            Storage::delete( $path . '/' . $asset->name );
            Storage::deleteDirectory( $path );
            \DB::commit();
            $msg = "Banner Asset Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Banner Asset not Deleted';
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
