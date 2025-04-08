<?php

namespace App\Storage;

use Illuminate\Support\Facades\Storage;

class StorageService{

    const DISK="public";

    public function store($path,$file,$name=''){
        if ($name) {
            $path = Storage::disk(self::DISK)->putFileAs($path ?? '', $file, $name);
        } else {
            $path = Storage::disk(self::DISK)->putFile($path ?? '', $file);
        }
        return $path;

    }

    public function getUrl($path){
        return asset('profile_photos/'.$path);
    }

    public function exists($path){
        return Storage::disk(self::DISK)->exists($path);
    }

    public function getFileAsResponse($path)
    {
        return Storage::disk(self::DISK)->response($path);
    }

    public function delete($path)
    {
        if (Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }

        return true;
    }

}
