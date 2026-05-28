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
        User::updateOrCreate(
            ['email' => 'moin69603@gmail.com'],
            [
                'name' => 'Ghulam Moin-Ud-Din',
                'password' => Hash::make('Moin@Farrokh123'),
                'role' => 'admin',
            ]
        );
    }
}
