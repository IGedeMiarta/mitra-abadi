<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Author;
use App\Models\Brand;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Settings;
use App\Models\SpecialProduct;
use App\Models\Tags;
use App\Models\Testimony;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
      
        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'role'  => 'admin'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Leader',
            'email' => 'leader@mail.com',
            'role'  => 'lead'
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@mail.com',
            'role'  => 'cust'
        ]);

        Settings::create([
            'key' => 'APP_NAME',
            'value' => 'mitraabadicv.com',
            'group' =>'APP',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'APP_MOBILE',
            'value' => '0000000000',
            'group' =>'APP',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'APP_ADDRESS',
            'value' => 'address',
            'group' =>'APP',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'APP_MAIL',
            'value' => 'info-email@mail.com',
            'group' =>'APP',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'BANK_NAME',
            'value' => 'BANK BCA',
            'group' =>'BANK',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'BANK_NUM',
            'value' => '000000',
            'group' =>'BANK',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'BANK_ACC',
            'value' => 'CV. Mitra Abadi',
            'group' =>'BANK',
            'type' => 1,
        ]);

        Settings::create([
            'key' => 'WA_TOKEN',
            'value' => 'ySSpZtAVytnPH77IyFqotXYA76WLz8rosT8VFs788cnXSa4HD2dWXNq1rwLuHQNw',
            'group' =>'WA',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'WA_ENDPOINT',
            'value' => 'https://jogja.wablas.com/api',
            'group' =>'WA',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'MAIL_MAILER',
            'value' => 'smtp',
            'group' =>'MAIL',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'MAIL_HOST',
            'value' => 'sandbox.smtp.mailtrap.io',
            'group' =>'MAIL',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'MAIL_PORT',
            'value' => '2525',
            'group' =>'MAIL',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'MAIL_USERNAME',
            'value' => '53e13a60761268',
            'group' =>'MAIL',
            'type' => 1,
        ]);
        Settings::create([
            'key' => 'MAIL_PASSWORD',
            'value' => '********3a58',
            'group' =>'MAIL',
            'type' => 1,
        ]);
    }
}
