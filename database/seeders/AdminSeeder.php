<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'          => 'حمدي غنيمي',
            'phone'         => '01014473872',
            'password'      => '01014473872',
            'role'          => RoleType::ADMIN,
        ]);
    }
}
