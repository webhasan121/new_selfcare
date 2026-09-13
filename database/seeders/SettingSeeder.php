<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {

        $settings = [
            ['User Auth', null, 'Auth Method', 'raw', '0', "0 for default user\n1 for API login"],

        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                [
                    'category' => $setting[0],
                    'sub_category' => $setting[1],
                    'name' => $setting[2],
                ],
                [
                    'type' => $setting[3],
                    'value' => $setting[4],
                    'description' => $setting[5],
                ]
            );
        }
    }
}
