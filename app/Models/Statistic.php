<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = StatisticTranslation::class;

    public static array $translatable = [
        'title',
    ];

    protected $fillable = [
        'id',
        'sort',
        'count',
        'status',
        'is_plus',
        'updated_at',
    ];
}
