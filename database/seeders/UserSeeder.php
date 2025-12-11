<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'is_admin' => true,
            'discount_percent' => 0,
            'created_at' => now()->subDays(30),
        ]);

        // Create regular users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 5,
                'created_at' => now()->subDays(25),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 0,
                'created_at' => now()->subDays(20),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike.johnson@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 10,
                'created_at' => now()->subDays(15),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 0,
                'created_at' => now()->subDays(12),
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 15,
                'created_at' => now()->subDays(10),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 0,
                'created_at' => now()->subDays(8),
            ],
            [
                'name' => 'Chris Miller',
                'email' => 'chris.miller@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 0,
                'created_at' => now()->subDays(6),
            ],
            [
                'name' => 'Lisa Garcia',
                'email' => 'lisa.garcia@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 20,
                'created_at' => now()->subDays(4),
            ],
            [
                'name' => 'Tom Anderson',
                'email' => 'tom.anderson@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 0,
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Anna Taylor',
                'email' => 'anna.taylor@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'discount_percent' => 8,
                'created_at' => now()->subDays(1),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Sample users created successfully!');
    }
}
