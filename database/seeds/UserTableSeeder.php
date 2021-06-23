<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = [
            [
               'name'=>'Admin',
               'email'=>'admin@admin.com',
               'level'=>'admin',
               'password'=> bcrypt('123456'),
               'flag' => 1,
            ],
            [
               'name'=>'Pegawai',
               'email'=>'pegawai@pegawai.com',
               'level'=>'pegawai',
               'password'=> bcrypt('123456'),
               'flag' => 1,
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
