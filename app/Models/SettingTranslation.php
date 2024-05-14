<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    protected $table = 'setting_translations';

    protected $fillable = [
        'id',
        'name',
        'value',
        'locale',
        'translatable_id',
        'created_at',
        'updated_at',
    ];
}
