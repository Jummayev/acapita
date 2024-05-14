<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use TranslatableTrait;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected static mixed $translationModel = CompanyTranslation::class;

    public static array $translatable = [
        'name',
    ];

    protected $fillable = [
        'sort',
        'status',
        'updated_at',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(CompanyImage::class, 'company_id', 'id');
    }
}
