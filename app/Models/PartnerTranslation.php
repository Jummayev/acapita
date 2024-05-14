<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerTranslation extends Model
{
    protected $fillable = [
        'content',
        'translatable_id',
        'locale',
    ];
}
