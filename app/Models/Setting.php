<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\FileManager\App\Models\File;

/**
 * This is the model class for table "settings".
 */
class Setting extends Model
{
    use TranslatableTrait;

    protected $table = 'settings';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = SettingTranslation::class;

    public static array $translatable = [
        'name',
        'value',
    ];

    protected $fillable = [
        'id',
        'sort',
        'status',
        'is_deleted',
        'created_at',
        'updated_at',
        'file_id',
        'slug',
        'link',
        'alias',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
