<?php

namespace Modules\Translation\App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemMessageTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message',
        'language',
        'system_message_id',
    ];

    public $table = 'system_messages_translations';
}
