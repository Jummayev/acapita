<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticTranslation extends Model
{
    protected $fillable = [
        'title',
        'translatable_id',
        'locale',
        'created_at',
        'updated_at',
    ];
}
