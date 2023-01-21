<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vish4395\LaravelFileViewer\LaravelFileViewer;

class FilesData extends Controller implements LaravelFileViewer
{
    use LaravelFileViewer;
    public function file_preview(Request $request){
        $filepath = 'public/word-template/' . $request->filename;
        $file_url = asset('storage/word-template/' . $request->filename);
        $file_data=[[
                'label' => __('Label'),
                'value' => "Value"
            ]
        ];
        return LaravelFileViewer::show($request->filename,$filepath,$file_url,$file_data);
    }
}
