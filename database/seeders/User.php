<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'Nguyễn Bá Thái',
                'email' => 'nobmtpro1@gmail.com',
                'password' => Hash::make(123)
            ],
            [
                'name' => 'Nguyễn Văn A',
                'email' => 'nobmtpro2@gmail.com',
                'password' => Hash::make(123)
            ],
        ]);
    }
}
