<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Admin\BannerRequest;
use App\Models\Banner;

class BannerController extends ApiController
{
    public function getBanner(BannerRequest $request)
    {
        $sTime = microtime(true);
        $status = true;
        $message = '';
        $banner = Banner::with('assets')->where('key', $request->get('banner_page'))->first();

        $data = [];
        if($banner) {
            $assets = [];
            foreach ($banner->assets as $key => $asset) {
                $assets[] = [
                    'image_url' => $asset->url(),
                    'name' => $asset->name
                ];
            }
            $data = [
                'name' => $banner->banner_page,
                'assets' => $assets
            ];
            $message = "Banner Success Retrieved";
        } else {
            $message = "Banner No Data";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'values' => [
                'banner'=>$data
            ],
            'time' => microtime(true)-$sTime
        ]);
        
    }
}
