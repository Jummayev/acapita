<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = AgreementTranslation::class;

    public static array $translatable = [
        'name',
        'items',
    ];

    protected $fillable = [
        'sort',
        'status',
        'updated_at',
    ];
}
