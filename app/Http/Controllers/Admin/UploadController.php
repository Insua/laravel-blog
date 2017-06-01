<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadNewFolderRequest;
use App\Services\UploadsManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager)
    {
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        $folder = $request->get('folder');
        $data = $this->manager->folderInfo($folder);

        return view('admin.upload.index',$data);
    }

    //创建新目录
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
        $folder = $request->get('folder').'/'.$new_folder;

        $result = $this->manager->createDirectory($folder);

        if($result === true)
        {
            return redirect()->back()->withSuccess("Folder '$new_folder' created");
        }

        $error = $result ? : "An error occurred creating directory.";
    }
}
