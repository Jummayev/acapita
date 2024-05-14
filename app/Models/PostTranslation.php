<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostTranslation extends Model
{
    protected $fillable = [
        'title',
        'description',
        'content',
        'file_id',
        'translatable_id',
        'locale',
        'is_main',
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function (PostTranslation $model) {
            $model->slug = Str::slug($model->title, '-').'-'.$model->id;
        });
    }
}
