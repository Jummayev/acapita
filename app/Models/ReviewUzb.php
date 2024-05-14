<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

class ReviewUzb extends Model
{
    use TranslatableTrait;

    protected $table = 'review_uzb';

    protected $fillable = [
        'status',
        'sort',
        'file_id',
        'updated_at',
    ];

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = ReviewUzbTranslation::class;

    public static array $translatable = [
        'title',
        'description',
        'content',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
