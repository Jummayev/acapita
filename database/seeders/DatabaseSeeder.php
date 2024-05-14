<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\FileManager\Database\Seeders\FileManagerDatabaseSeeder;
use Modules\Translation\Database\Seeders\TranslationDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'login' => 'admin',
            'email' => 'admin@localhost',
            'password' => Hash::make('admin123'),
            'status' => User::STATUS_ACTIVE,
        ]);
        Role::create([
            'user_id' => $admin->id,
            'role' => User::ROLE_ADMIN,
        ]);
        $this->call([
            FileManagerDatabaseSeeder::class,
            TranslationDatabaseSeeder::class,
        ]);
    }
}
