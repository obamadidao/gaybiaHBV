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
        // Chạy RoleSeeder trước để tạo các vai trò
        $this->call(RoleSeeder::class);
        
        // Sau đó chạy UserSeeder để tạo người dùng với vai trò tương ứng
        $this->call(UserSeeder::class);
    }
}
