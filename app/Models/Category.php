<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use TranslatableTrait;

    protected $table = 'categories';

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = CategoryTranslation::class;

    public static array $translatable = [
        'title',
    ];

    protected $fillable = [
        'sort',
        'status',
        'updated_at',
    ];
}
