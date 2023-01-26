<?php

namespace App\Http\Controllers;

use App\Events\InterphoneEvent;
use App\Models\Interphone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesData extends Controller
{
    public function interphone(Request $request){
        $originalName = $request->audio_data->getClientOriginalName();
        $path = "/uploads/interphone/" . time() . ".mp3";

        Storage::disk('public')->put($path, file_get_contents($request->audio_data));

        $interphone = new Interphone;
        $interphone->from = auth()->user()->id;
        $interphone->to = intval($request->user_id);
        $interphone->view = false;
        $interphone->path = "/storage" . $path;
        $interphone->save();

        return event(new InterphoneEvent(intval($request->user_id), "Notificacion de interphone", $path));

    }
}

