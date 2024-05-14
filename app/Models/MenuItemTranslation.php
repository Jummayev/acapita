<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{
    protected $fillable = [
        'title',
        'translatable_id',
        'locale',
    ];
}
