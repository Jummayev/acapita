<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\FileManager\App\Models\File;

class Partner extends Model
{
    use TranslatableTrait;

    protected $table = 'partners';

    public static array $translatable = [
        'content',
    ];

    protected static mixed $translationModel = PartnerTranslation::class;

    protected $with = ['translation'];

    protected $hidden = ['translation'];

    protected $fillable = [
        'is_home',
        'sort',
        'logo_id',
        'file_id',
        'updated_at',
        'status',
    ];

    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function socials(): MorphToMany
    {
        return $this->morphToMany(SocialNetwork::class, 'socialable', 'socialables', 'socialable_id', 'social_id')->withPivot('link');
    }

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::saved(function (Partner $partner) {
            if ($partner->is_home) {
                self::withoutEvents(function () use ($partner) {
                    self::where('is_home', 1)
                        ->where('id', '!=', $partner->id)
                        ->update(['is_home' => 0]);
                });
            }
        });
    }
}
