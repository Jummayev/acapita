<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementTranslation extends Model
{
    protected $fillable = [
        'name',
        'items',
        'translatable_id',
        'locale',
    ];

    protected $casts = ['items' => 'array'];
}
