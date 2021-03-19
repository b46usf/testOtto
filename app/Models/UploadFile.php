<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class UploadFile extends Storage
{
    public static function upload($file,$namefile) {
        $path = Storage::putFileAs('public/img',$file,$namefile);
    }
}