<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

/**
 * This is the model class for table "pages".
 */
class Page extends Model
{
    use TranslatableTrait;

    protected $table = 'pages';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = PageTranslation::class;

    public static array $translatable = [
        'title',
        'description',
        'content',
    ];

    protected $fillable = [
        'updated_at',
        'created_at',
        'id',
        'link',
        'type',
        'file_id',
        'sort',
        'status',
        'is_deleted',
        'slug',
        'files',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
