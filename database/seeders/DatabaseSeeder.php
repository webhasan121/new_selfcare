<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $customer = User::factory()->create([
            'name' => 'Test customer',
            'email' => 'customer@selfcare.test',
            'password' => Hash::make('12345678'),
        ]);

        //staff user
        $staff = User::factory()->create([
            'name' => 'Test staff',
            'email' => 'support_staff@selfcare.test',
            'password' => Hash::make('12345678'),
        ]);

        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionSeeder::class,
        ]);

        $customer->assignRole('customer');
        $staff->assignRole('support_staff');

    }
}
