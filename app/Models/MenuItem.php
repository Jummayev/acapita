<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = MenuItemTranslation::class;

    public static array $translatable = [
        'title',
    ];

    protected $fillable = [
        'slug',
        'alias',
        'sort',
        'status',
        'updated_at',
        'menu_id',
        'menu_item_parent_id',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_parent_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_item_parent_id', 'id');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_item_parent_id', 'id')
            ->where('status', 1);
    }
}
