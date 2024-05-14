<?php

namespace Modules\FileManager\App\Helpers;

use App\Exceptions\ServerErrorException;

class FileManagerHelper
{
    public static function getThumbsImage(): array
    {
        if (! ($thumbs = config('filemanager.thumbs'))) {
            throw new ServerErrorException("'thumbs' params is not founded");
        }

        return $thumbs;
    }

    public static function getImagesExt(): array
    {
        if (! ($images_ext = config('filemanager.images_ext'))) {
            throw new ServerErrorException("'images_ext' params is not founded");
        }

        return $images_ext;
    }
}
