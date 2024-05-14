<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\FileManager\App\Models\File;

class Product extends Model
{
    use TranslatableTrait;

    protected $table = 'products';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = ProductTranslation::class;

    protected $fillable = [
        'sort',
        'color',
        'category_id',
        'url',
        'is_menu',
        'updated_at',
        'status',
    ];

    public static array $translatable = [
        'title',
        'description',
        'instructions',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'product_images', 'product_id', 'image_id')->orderByPivot('id', 'asc');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereRaw('`products`.`status` = 1');
    }
}
