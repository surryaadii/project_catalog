<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends ApiController
{
    public function getPage(Request $request) {
        $sTime = microtime(true);
        $status = true;
        $message = '';
        $page = Page::with('assets')->where('slug', $request->get('slug'))->first();

        $data = [];
        if($page) {
            $assets = [];
            foreach ($page->assets as $key => $asset) {
                $assets[] = [
                    'image_url' => $asset->url(),
                    'name' => $asset->name
                ];
            }
            $data = [
                'title' => $page->title,
                'content' => $page->body,
                'assets' => $assets
            ];
            $message = "Page Success Retrieved";
        } else {
            $message = "Page No Data";
        }

        return response()->json([
            'status' => $status,
            'message' => $message,
            'values' => [
                'page'=>$data
            ],
            'time' => microtime(true)-$sTime
        ]);
    }
}
