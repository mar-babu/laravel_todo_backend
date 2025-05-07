<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'dev@ar-techpro.com'],
            [
                'name' => 'Developer',
                'email' => 'dev@ar-techpro.com',
                'password' => Hash::make('123456789'),
            ]
        );

        Task::factory(15)->create();
    }
}
