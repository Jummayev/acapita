<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    protected $table = 'page_translations';

    protected $fillable = [
        'id',
        'title',
        'content',
        'locale',
        'translatable_id',
        'description',
        'created_at',
        'updated_at',
    ];
}
