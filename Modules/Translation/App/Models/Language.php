<?php

namespace Modules\Translation\App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'name',
        'code',
        'status',
        'icon_id',
    ];

    public static function getId(string $code): int
    {
        return self::where('code', $code)->firstOrFail()->id;
    }
}
