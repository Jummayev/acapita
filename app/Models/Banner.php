<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

class Banner extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = BannerTranslation::class;

    public static array $translatable = [
        'title',
        'link',
    ];

    protected $fillable = [
        'sort',
        'file_id',
        'updated_at',
        'status',
        'page_id',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
