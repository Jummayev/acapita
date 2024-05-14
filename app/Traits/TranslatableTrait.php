<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Lang;
use Modules\Translation\App\Models\Language;

trait TranslatableTrait
{
    public static bool $isTranslatable = true;

    public static function getTranslationModel(): string
    {
        $model_name = class_basename(self::class);

        return "{$model_name}Translation";
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        self::created(function ($model) {
            $translation = request()->only(self::$translatable);
            if (! empty($translation)) {
                $translation['translatable_id'] = $model->id;
                $langs = Language::where('status', 1)->get();
                foreach ($langs as $key => $lang) {
                    $translation['locale'] = $lang->code;
                    self::$translationModel::updateOrCreate([
                        'translatable_id' => $translation['translatable_id'],
                        'locale' => $translation['locale'],
                    ], $translation);
                }

            }
        });
        static::updating(function ($model) {
            $translation = request()->only(self::$translatable);
            if (! empty($translation)) {
                $translation['translatable_id'] = $model->id;
                $translation['locale'] = Lang::getLocale();
                self::$translationModel::updateOrCreate([
                    'translatable_id' => $translation['translatable_id'],
                    'locale' => $translation['locale'],
                ], $translation);
            }
        });
    }

    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();
        if (! self::$isTranslatable) {
            return $attributes;
        }
        $hiddenAttributes = $this->getHidden();
        $translation = $this->translation ?? null;
        foreach (self::$translatable as $field) {
            if (in_array($field, $hiddenAttributes)) {
                continue;
            }
            $attributes[$field] = $translation?->$field;
        }

        return $attributes;
    }

    public function translation(): HasOne
    {
        return $this->hasOne(self::$translationModel, 'translatable_id')->where('locale', Lang::getLocale());
    }

    public function translations(): HasMany
    {
        return $this->hasMany(self::$translationModel, 'translatable_id');
    }

    public function scopeNotTranslated(Builder $builder): Builder
    {
        self::$isTranslatable = false;
        $builder->without('translation');

        return $builder;
    }
}
