<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CommonHelper{
    public static function convertDateToDMY($date){
        return date('d/m/Y',strtotime($date));
    }
    public static function convertTitleToSlug($title, $separator){
        return Str::slug($title,$separator);
    }
    public static function uploadImage($file, $nameFile, $folder){
        $file->move(public_path($folder),$nameFile);
        return true;
    }
    public static function cropImage($file, $nameFile, $width, $height, $folder){
        $image_size = Image::make($file->getRealPath());
        $image_size->resize($width,$height);
        $image_size->save(public_path($folder.$nameFile));
        return true;
    }

    public static function cropImage2($file, $nameFile, $width, $height, $folder){
        $image_size = Image::make($file->getRealPath());
        $image_size->fit($width,$height);
        $image_size->save(public_path($folder.$nameFile));
        return true;
    }
    public static function deleteImage($nameFile,$folder){
        $path = $folder.$nameFile;
        File::delete(\public_path($path));
        return true;
    }
}
