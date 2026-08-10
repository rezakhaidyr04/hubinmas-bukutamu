<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(['key' => 'admin_pin'], ['value' => '123456']);
        \App\Models\Setting::updateOrCreate(['key' => 'require_phone'], ['value' => '0']);
        \App\Models\Setting::updateOrCreate(['key' => 'require_email'], ['value' => '0']);
        \App\Models\Setting::updateOrCreate(
            ['key' => 'guest_categories'],
            ['value' => json_encode(\App\Models\Setting::defaultCategories(), JSON_UNESCAPED_UNICODE)]
        );
        \App\Models\Setting::updateOrCreate(
            ['key' => 'tujuan_options'],
            ['value' => json_encode(\App\Models\Setting::defaultTujuanOptions(), JSON_UNESCAPED_UNICODE)]
        );
    }
}
