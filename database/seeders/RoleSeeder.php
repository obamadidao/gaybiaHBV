<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'display_name' => 'Quản trị viên'],
            ['name' => 'user', 'display_name' => 'Người dùng'],
            // ['name' => 'manager', 'display_name' => 'Quản lý'],
        ]);
    }
}

