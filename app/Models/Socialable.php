<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Socialable extends Model
{
    protected $fillable = [
        'socialable_id',
        'socialable_type',
        'social_id',
        'link',
    ];

    public function socialable(): MorphTo
    {
        return $this->morphTo();
    }
}
