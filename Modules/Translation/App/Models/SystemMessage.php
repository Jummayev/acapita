<?php

namespace Modules\Translation\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemMessage extends Model
{
    protected $fillable = [
        'key',
        'message',
    ];

    protected $table = 'system_messages';

    public function translations(): HasMany
    {
        return $this->hasMany(SystemMessageTranslation::class);
    }
}
