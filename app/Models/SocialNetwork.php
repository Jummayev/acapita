<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

class SocialNetwork extends Model
{
    protected $fillable = [
        'name',
        'logo_id',
    ];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
