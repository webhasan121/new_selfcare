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
            [null, null, 'ftp_link', 'raw', '', 'Site-specific FTP URL; configure after deployment.'],
            [null, null, 'tblpayment_col_by', 'raw', '', 'Site-specific payment collector ID.'],
            [null, null, 'tblpayment_entry_by', 'raw', '', 'Site-specific payment entry user ID.'],
            [null, null, 'tblpayment_ledger_id', 'raw', '', 'Site-specific payment ledger ID.'],

            [null, null, 'require_contact_on_register', 'raw', '0', null],
            [null, null, 'phone_verification_mask', 'raw', '1', null],
            [null, null, 'phone_verification_mask_character', 'raw', '*', null],
            [null, null, 'phone_verification_unmasked_length', 'raw', '3', null],

            [null, null, 'acc_statement_months_count', 'raw', '-5', null],

            [null, null, 'sslcommerz_environment', 'raw', 'live', null],
            [null, null, 'sslcommerz_test_store_id', 'raw', '', 'SSLCommerz credential; configure after deployment.'],
            [null, null, 'sslcommerz_live_store_id', 'raw', '', 'SSLCommerz credential; configure after deployment.'],
            [null, null, 'sslcommerz_test_store_password', 'raw', '', 'SSLCommerz credential; configure after deployment.'],
            [null, null, 'sslcommerz_live_store_password', 'raw', '', 'SSLCommerz credential; configure after deployment.'],

            [
                null,
                null,
                'sslcommerz_test_api_url',
                'raw',
                'https://sandbox.sslcommerz.com/gwprocess/v4/api.php',
                null
            ],
            [
                null,
                null,
                'sslcommerz_live_api_url',
                'raw',
                'https://securepay.sslcommerz.com/gwprocess/v4/api.php',
                null
            ],
            [
                null,
                null,
                'sslcommerz_test_validation_api_url',
                'raw',
                'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php',
                null
            ],
            [
                null,
                null,
                'sslcommerz_live_validation_api_url',
                'raw',
                'https://securepay.sslcommerz.com/validator/api/validationserverAPI.php',
                null
            ],

            [null, null, 'allow_adding_dialer', 'raw', '1', null],
            [null, null, 'dialer_contact_required', 'raw', '0', null],
            [null, null, 'dialer_contact_verification_required', 'raw', '0', null],
            [null, null, 'dialer_contact_auto', 'raw', '0', null],

            [null, null, 'enable_phone_auth', 'raw', '1', null],

            ['sms_gateway', 'default', 'country_prefix', 'raw', '88', null],
            [
                'sms_gateway',
                'default',
                'continue_on_invalid_gateway_name',
                'raw',
                '0',
                "bool: if true, loop will continue if 'active_gateways' has invalid name"
            ],
            [
                'sms_gateway',
                'default',
                'save_log',
                'raw',
                '2',
                "0: false\n1: true\n2: failed only"
            ],
            [
                'sms_gateway',
                'default',
                'active_gateways',
                'raw',
                '',
                $gatewayDescription
            ],

            ['sms_gateway', 'ajuratech', 'name', 'raw', 'Ajuratech', null],
            [
                'sms_gateway',
                'ajuratech',
                'url',
                'raw',
                'http://sms.ajuratech.com/api/mt/SendSMS',
                null
            ],
            ['sms_gateway', 'ajuratech', 'username', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'ajuratech', 'password', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'ajuratech', 'sender', 'raw', '', 'Gateway sender/masking value; configure after deployment.'],

            ['sms_gateway', 'rankstel', 'name', 'raw', 'RanksTel', null],
            [
                'sms_gateway',
                'rankstel',
                'url',
                'raw',
                'http://api.rankstelecom.com/api/v3/sendsms/plain',
                null
            ],
            ['sms_gateway', 'rankstel', 'username', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'rankstel', 'password', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'rankstel', 'sender', 'raw', '', 'Gateway sender/masking value; configure after deployment.'],

            ['company', 'default', 'logo', 'raw', 'images/custom/logo_400_wide.png?v=1', null],

            ['layout', 'logo', 'auth', 'raw', '', null],
            ['layout', 'logo', 'top_bar', 'raw', '', null],

            ['sms_gateway', 'brilliant', 'name', 'raw', 'Brilliant', null],
            [
                'sms_gateway',
                'brilliant',
                'url',
                'raw',
                'http://36.255.68.244:6005/api/v2/SendSMS',
                null
            ],
            ['sms_gateway', 'brilliant', 'username', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'brilliant', 'password', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'brilliant', 'sender', 'raw', '', 'Gateway sender/masking value; configure after deployment.'],

            ['sms_gateway', 'novocom', 'sender', 'raw', '', 'Gateway sender/masking value; configure after deployment.'],
            ['sms_gateway', 'novocom', 'password', 'raw', '', 'Gateway credential; configure after deployment.'],
            ['sms_gateway', 'novocom', 'username', 'raw', '', 'Gateway credential; configure after deployment.'],
            [
                'sms_gateway',
                'novocom',
                'url',
                'raw',
                'https://sms.novocom-bd.com/api/v2/SendSMS',
                null
            ],
            ['sms_gateway', 'novocom', 'name', 'raw', 'Novocom', null],

            [
                'social',
                'provider',
                'facebook',
                'raw',
                '{"label":"Login with Facebook","icon":"fa fa-facebook","color":"#3b5998","url":"https://www.facebook.com","enabled":true}',
                null
            ],
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
