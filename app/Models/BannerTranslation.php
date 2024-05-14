<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerTranslation extends Model
{
    protected $fillable = [
        'title',
        'link',
        'translatable_id',
        'locale',
    ];
}
