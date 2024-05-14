<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use TranslatableTrait;

    public static array $translatable = [
        'name',
        'status',
    ];

    protected static mixed $translationModel = RegionTranslation::class;

    protected $table = 'regions';

    protected $hidden = ['translation'];

    protected $with = ['translation'];

    protected $fillable = [
        'id',
        'code',
        'country_id',
        'tax_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
