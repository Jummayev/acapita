<?php

namespace Modules\FileManager\App\DTO;

use Illuminate\Http\UploadedFile;

class GeneratePathFileDTO
{
    public UploadedFile $file;

    public bool $useFileName = false;

    public bool $is_front = false;
}
