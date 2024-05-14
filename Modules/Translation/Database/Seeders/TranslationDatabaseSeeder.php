<?php

namespace Modules\Translation\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Translation\App\Models\Language;

class TranslationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = [
            [
                'name' => 'UZB',
                'code' => 'uz',
                'status' => 1,
            ],
            [
                'name' => 'ЎЗБ',
                'code' => 'oz',
                'status' => 1,
            ],
            [
                'name' => 'RUS',
                'code' => 'ru',
                'status' => 1,
            ],
            [
                'name' => 'EN',
                'code' => 'en',
                'status' => 1,
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
