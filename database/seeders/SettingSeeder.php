<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'general' => [
                'app_name' => 'Laravue Dashboard',
                'app_tagline' => 'HexaDash admin portal',
                'support_email' => 'support@laravue.test',
                'timezone' => 'UTC',
            ],
            'appearance' => [
                'primary_color' => '#5f63f2',
                'sidebar_default_collapsed' => 0,
                'default_theme' => 'light',
            ],
            'notifications' => [
                'notify_new_user' => 1,
                'notify_weekly_report' => 1,
                'notify_product_updates' => 0,
            ],
        ];

        foreach ($defaults as $group => $values) {
            Setting::setMany($values, $group);
        }
    }
}
