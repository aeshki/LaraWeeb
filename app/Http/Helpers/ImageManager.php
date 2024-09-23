<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait ImageManager
{
    public static function saveImage(UploadedFile $file, string $fileName, string $path, bool $clear = true): string
    {
        if ($clear) {
            self::clearImage("$path/$fileName");
        }

        $fileName = "$fileName.".$file->getClientOriginalExtension();
        
        $file->storeAs("public/$path", $fileName);

        return $fileName;
    }

    public static function clearImage($path): void
    {
        $images = glob(public_path("storage/$path.*"));

        foreach ($images as $image_path) {
            File::delete($image_path);
        }
    }

    public static function removeImage($path): bool
    {
        $path = public_path("storage/$path");

        return File::exists($path) && File::delete($path);
    }
}
