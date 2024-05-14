<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'instructions',
        'translatable_id',
        'locale',
    ];

    protected $casts = [
        'instructions' => 'array',
    ];
}
