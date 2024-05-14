<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    protected $fillable = [
        'title',
        'translatable_id',
        'locale',
    ];
}
