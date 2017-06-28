<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class FileController extends Controller
{
    public function download(Request $request)
    {
        return response()->download(config('filesystems.disks.local.root').$request->get('path'));
    }
}
