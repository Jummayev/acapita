<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeTranslation extends Model
{
    protected $fillable = [
        'full_name',
        'position',
        'content',
        'translatable_id',
        'locale',
    ];
}
