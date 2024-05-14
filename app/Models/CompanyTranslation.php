<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTranslation extends Model
{
    protected $fillable = [
        'name',
        'translatable_id',
        'locale',
    ];
}
