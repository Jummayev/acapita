<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use TranslatableTrait;

    protected $table = 'menus';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = MenuTranslation::class;

    public static array $translatable = [
        'title',
    ];

    protected $fillable = [
        'slug',
        'alias',
        'sort',
        'updated_at',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')->whereNull('menu_item_parent_id');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')
            ->where('status', 1)
            ->whereNull('menu_item_parent_id');
    }
}
