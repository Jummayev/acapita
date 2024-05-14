<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewUzbTranslation extends Model
{
    protected $table = 'review_uzb_translations';

    protected $fillable = [
        'title',
        'description',
        'content',
        'translatable_id',
        'locale',
    ];
}
