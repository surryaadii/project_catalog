<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Http\Response;

class AssetController extends Controller
{
    public function downloadAsset(Request $request)
    {
        $sTime = microtime(true);

        $id = $request->get('id');

        $asset = Asset::findOrFail($id);
        if( $asset ){
            $path = $asset->create_path($asset->created_at, $asset->id);
            $outputFile = storage_path( 'app/'.$path.'/'.$asset->name);
            header('Content-Disposition: attachment; filename="'.$asset->name.'"');
            header('Content-Type: application/octet-stream');
            header("Content-Length: " . filesize($outputFile));
            echo \File::get($outputFile);
            die();
            // return response()->download($outputFile);
            // return (new Response($outputFile, 200))
            //     ->header('Content-Type', $asset->mime_type)
            //     ->header('Content-length', filesize($outputFile))
            //     ->header('Content-Disposition', 'attachment; filename="'.$asset->name.'"');
        }
    }
}
