<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $gatewayDescription = "list of comma separated gateways (sub_category).\n\n"
            . "dataset for each gateway:\nurl,\nusername,\npassword,\n"
            . "http_method: default is GET if not provided,\nname: gateway name,\n"
            . "namespace: if given, default namespace (App\\Helpers\\SmsGateways) will be ignored,\n"
            . "class_name: if given, default classname (ucfirst(\$gateway) . \"SmsGatewayHelper\") will be ignored,\n"
            . "data_coding: gateway specific value, if needed\nsender: masking,\n"
            . "additional_data: json key value pair, if needed,\n";

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
