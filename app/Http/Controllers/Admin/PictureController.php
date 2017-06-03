<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class PictureController extends Controller
{
    public function view(Request $request)
    {
        header('Content-Type: '.$request->get('mimetype'));
        echo Storage::get($request->get('path'));
    }
}
