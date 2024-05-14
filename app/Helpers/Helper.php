<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class Helper
{
    public static function convertToWebp(string $path, ?string $outputPath = null, int $quality = 100): bool
    {
        $info = getimagesize($path);
        $isAlpha = false;

        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'image/gif':
                $isAlpha = true;
                $image = imagecreatefromgif($path);
                break;
            case 'image/png':
                $isAlpha = true;
                $image = imagecreatefrompng($path);
                break;
            default:
                return false;
        }

        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        imagewebp($image, $outputPath, $quality);

        return File::exists($outputPath);
    }
}
