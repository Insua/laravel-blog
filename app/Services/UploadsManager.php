<?php

namespace App\Services;


use Dflydev\ApacheMimeTypes\PhpRepository;
use Storage;

class UploadsManager
{
    protected $disk;
    protected $mimeDetect;

    public function __construct(PhpRepository $mimeDetect)
    {
        $this->disk = Storage::disk(config('blog.uploads.storage'));
        $this->mimeDetect = $mimeDetect;
    }

    public function folderInfo($folder)
    {
        $folder = $this->cleanFolder($folder);

        $breadcrumbs = $this->breadcrumbs($folder);
        $slice = array_slice($breadcrumbs,-1);
        $folderName = current($slice);
        $breadcrumbs = array_slice($breadcrumbs,0,1);

        $subfolders = [];
        foreach(array_unique($this->disk->directories($folder)) as $subfolder)
        {
            $subfolders["/$subfolder"] = basename($subfolder);
        }

        $files = [];
        foreach($this->disk->files($folder) as $path)
        {
            $files[] = $this->fileDetails($path);
        }

        return compact('folder','folderName','breadcrumbs','subfolders','files');
    }

    protected function cleanFolder($folder)
    {
        return '/'.trim(str_replace('..','',$folder),'/');
    }

    protected function breadcrumbs($folder)
    {
        $folder = trim($folder,'/');
        $crumbs = ['/'=>'root'];

        if(empty($folder))
        {
            return $crumbs;
        }

        $folders = explode('/',$folder);
        $build = '';
        foreach($folders as $folder)
        {
            $build .= '/'.$folder;
            $crumbs[$build] = $folder;
        }

        return $crumbs;
    }

    protected function fileDetails($path)
    {
        $path = '/'.ltrim($path,'/');
    }
}
