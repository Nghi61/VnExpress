<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_name' => 'nghi61',
                'avatar' => 'http://localhost:8000/storage/img/users/default.png',
                'name' => 'Nguyễn Văn Nghi',
                'email' => 'nghinvps23655@fpt.edu.vn',
                'password' => Hash::make(123456789),
                'role' => '0',
            ],
            [
                'user_name' => 'phuc03',
                'avatar' => 'http://localhost:8000/storage/img/users/default.png',
                'name' => 'Trần Vỉnh Phúc',
                'email' => 'phuc22224@fpt.edu.vn',
                'password' => Hash::make(123456789),
                'role' => '1',
            ],
        ];

        foreach ($data as $record) {
            User::create($record);
        }
    }
}
