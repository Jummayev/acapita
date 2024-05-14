<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegionTranslation extends Model
{
    protected $table = 'region_translations';

    protected $fillable = [
        'id',
        'name',
        'status',
        'region_id',
        'locale',
        'created_at',
        'updated_at',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
