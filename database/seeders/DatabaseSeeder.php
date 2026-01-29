<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a "Demo School" using the CORRECT column name
        // We use insertOrIgnore so it doesn't crash if it already exists
        DB::table('institutions')->insertOrIgnore([
            'institution_id' => 1,  // <--- This was the missing key!
            'name' => 'Demo School',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Create the User and link them to School #1
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'institution_id' => 1,
        ]);
    }
}