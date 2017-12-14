<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'name' => "Muhammad Mahin Dar",
            'email' => "muhammadmahindar".'@gmail.com',
            'password' => bcrypt('secret'),
            'active'=>1,
            'branch_id'=>1,
            'department_id'=>1,
            'company_id'=>1,
            'avatar'=>"default.jpg",
            'delete_status'=>1,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); //
    }
}
