<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء مستخدم مدير واحد وتحديد معلوماته يدوياً
        User::factory()->admin()->create([
            'student_id' => '2599',
            'name' => 'shadi',
            'password' => Hash::make('55550000'),
            'phone' => '0000000000',
            'address' => 'Admin Address',
            'father_name' => 'Admin Father',
            'mother_name' => 'Admin Mother',
            'gender' => 'ذكر',
        ]);
    }
}
