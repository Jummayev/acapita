<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

class CompanyImage extends Model
{
    protected $fillable = [
        'name',
        'link',
        'image_id',
        'company_id',
    ];

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id', 'id');
    }
}
