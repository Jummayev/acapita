<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTranslation extends Model
{
    protected $fillable = [
        'content',
        'locale',
        'translatable_id',
    ];
}
