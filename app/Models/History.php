<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = HistoryTranslation::class;

    public static array $translatable = [
        'content',
    ];

    protected $fillable = [
        'year',
        'status',
        'sort',
        'updated_at',
    ];
}
