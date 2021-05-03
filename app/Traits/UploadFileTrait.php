<?php

namespace App\Traits;

trait UploadFileTrait {
    
    public function uploadImage($image)
    {
        $filename = date('Ymdhis') . '.' . $image->getClientOriginalExtension();
        $path = public_path('uploads/images/');
        $image->move($path, $filename);
        return $filename;
    }
}