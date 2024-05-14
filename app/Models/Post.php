<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Lang;
use Modules\FileManager\App\Models\File;

class Post extends Model
{
    use TranslatableTrait;

    public static array $translatable = [
        'title',
        'description',
        'content',
        'file_id',
        'translatable_id',
        'slug',
        'is_main',
        'translatable_id',
    ];

    protected static mixed $translationModel = PostTranslation::class;

    protected $table = 'posts';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected $fillable = [
        'published_at',
        'view_count',
        'is_top',
        'status',
    ];

    public function file(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'post_translations', 'translatable_id', 'file_id')
            ->wherePivot('post_translations.locale', Lang::getLocale())
            ->orderByPivot('post_translations.id');
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->whereRaw("exists(select post_translations.slug from post_translations where post_translations.slug = '$slug' and post_translations.translatable_id = posts.id)", [$slug]);
    }
}
