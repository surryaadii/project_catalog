<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Page;
use App\Models\Asset;

class PageController extends Controller
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
        $total = Page::count();
        $filtered = 0;
        $data = [];
        $search = $request->input('search')['value'];

        $orderColumnIndex = $request->input('order')[0]['column'];
        $orderColumn = $request->input('columns')[$orderColumnIndex]['data'];
        $orderDir = $request->input('order')[0]['dir'];

        
        if ($search) {
            $q = '%'.$search.'%';
            $query = Page::whereTranslationIlike('title', $q)->orderByTranslationOrModel($orderColumn, $orderDir);
            $filtered = $query->count();
            $pages = $query->offset($start)->limit($length)->get();
        } else {
            $pages = Page::orderByTranslationOrModel($orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        foreach ($pages as $page) {
            $data[] = [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'body' => $page->body,
                'created_at' => $page->created_at,
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
    public function store(Request $request)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = new Page;
            
            $data = [];
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['title'] = $request->get($locale. '_title');
                $data[$locale]['body'] = $request->get($locale. '_body');
            }
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Page Success Created";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Page not Created';
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
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {        
            $model = Page::findOrfail($id);
            $daata = [];
            foreach (config('translatable.locales') as $locale) {
                $data[$locale]['title'] = $request->get($locale. '_title');
                $data[$locale]['body'] = $request->get($locale. '_body');
            }
            if ($model->fill($data) && $model->save()) {
                \DB::commit();
                $msg = "Page Success Edited";
                $status = true;
                $code = 200;
                $message = 'Success';
            }
        } catch (\Throwable $e) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Page not Edited';
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
            $model = Page::findOrFail($id);
            $model->delete();
            \DB::commit();
            $msg = "Page Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Page not Deleted';
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

    public function indexPageAssets(Request $request, $id)
    {
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $total = Page::findOrFail($id)->assets()->count();
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
            $query = Page::findOrFail($id)->assets()->where('name', 'ilike', $q)->orderBy('assets.'.$orderColumn, $orderDir);
            $filtered = $query->count();
            $page_assets = $query->offset($start)->limit($length)->get();
        } else {
            $page_assets = Page::findOrFail($id)->assets()->orderBy('assets.'.$orderColumn, $orderDir)->offset($start)->limit($length)->get();
            $filtered = $total;
        }

        
        foreach($page_assets as $asset) {
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
            $page = Page::findOrFail($id);
            
            $asset = new Asset;
            $asset->name = $request->file->getClientOriginalName();
            $asset->extension = $request->file->extension();
            $asset->mime_type = $request->file->getClientMimeType();
            $asset->size = $request->file->getSize();
            $asset->save();

            $page->assets()->attach($asset);
        
            $path = $asset->create_path( $asset->created_at, $asset->id );
        
            $request->file->storeAs(
                $path,
                $asset->name
            );
            $asset->generates();
            \DB::commit();
            $msg = "Page Asset Success Uploaded";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th){
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Page Asset not Uploaded';
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

    public function deleteAssetPage($idPage, $idAsset) {
        \DB::beginTransaction();
        $status = false;
        $code = 422;
        $message = '';
        $sTime = microtime(true);
        try {
            $page = Page::findOrFail($idPage);
            $assetQuery = $page->assets()->where('asset_id', $idAsset);
            $asset = $assetQuery->first();
            $assetQuery->delete(); 
            $path = $asset->create_path( $asset->created_at, $asset->id );
            Storage::delete( $path . '/' . $asset->name );
            Storage::deleteDirectory( $path );
            \DB::commit();
            $msg = "Page Asset Success Deleted";
            $status = true;
            $code = 200;
            $message = 'Success';
        } catch (\Throwable $th) {
            \DB::rollback();
            $status = false;
            $message = 'Unprocessable Entity';
            $msg = 'Page Asset not Deleted';
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
