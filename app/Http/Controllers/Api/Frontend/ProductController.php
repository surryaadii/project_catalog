<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Product;

class ProductController extends ApiController
{
    public function index(Request $request)
    {
        $sTime = microtime(true);
        $status = true;
        $message = '';

        $page = $request->input('page');
        $per_page = (int)$request->input('per_page') > 0 ? $request->input('per_page') : 10;
        $start = 0;
        $maxPage = 0;
        $summaryStart = 0;
        $summaryEnd = 0;
        $summaryTotalRow = 0;
        if ($page > 0) {
            $start = ( ($page - 1) * $per_page );
        }

        $queryGetIdsCategory = Category::with(['childrenRecursive' => function($q) use ($request) {
            if($request->get('sub_category')) $q->where('slug', $request->get('sub_category'));
        }]);
        if($request->get('category')) $queryGetIdsCategory->where('slug', $request->get('category'));
        $getIdsCategory = $queryGetIdsCategory->get()->toArray();
        $idsCategory = array_column($this->flatten($getIdsCategory), 'id');

        $query = Product::with('category', 'assets')->whereIn('category_id', $idsCategory);
        if($request->get('q')) $query->whereTranslationLike('name', '%'.$request->get('q').'%');
        $totalRow = $query->count();
        $products = $query->offset($start)->limit($per_page)->orderBy('created_at', 'DESC')->get();

        $data = [];
        if(count($products)) {
            foreach ($products as $k => $product) {
                $assets = [];
                foreach ($product['assets'] as $key => $asset) {
                    $assets[] = [
                        'name' => $asset['name'],
                        'url' => $asset->url(),
                    ];
                }
                $diffDays = Carbon::parse($product->created_at);
                $data[] = [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'slug' => $product['slug'],
                    'category_name' => $product['category']['name'],
                    'assets' => $assets,
                    'is_new' => $diffDays->diffInDays(Carbon::now()) <= 1 ? true : false
                ];
            }
            $summaryStart = ($per_page * ($page - 1) + 1);
            $summaryEnd = count($products) + ($summaryStart - 1);
            $summaryTotalRow = $totalRow;
            $maxPage = ceil($summaryTotalRow / $per_page);

            $message = 'Products Success Retrieved';
        } else {
            $message = 'Products No Data';
        }

        $summary = [
            'start' => $summaryStart,
            'end' => $summaryEnd,
            'total_row' => $summaryTotalRow,
            'per_page' => (int)$per_page,
            'current_page' => (int)$page,
            'max_page' => $maxPage
        ];
        
        //    $flatten = $this->flatten($data);
        //    foreach ($flatten as $key => $fl) {
        //         // eliminate categories from $flatten array
        //         if (!array_key_exists('category_id', $fl)) {
        //             unset($flatten[$key]);
        //         }
        //     }
        //     dd($flatten);

        return response()->json([
            'status' => $status,
            'message' => $message,
            'values' => [
                'summary' => $summary,
                'products'=>$data
            ],
            'time' => microtime(true)-$sTime
        ]);
    }

    public function flatten($array)
    {
            $flatArray = [];

            if (!is_array($array)) {
                $array = (array)$array;
            }

            foreach($array as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $flatArray = array_merge($flatArray, $this->flatten($value));
                } else {
                    $flatArray[0][$key] = $value;
                }
            }

            return $flatArray;
}
}
