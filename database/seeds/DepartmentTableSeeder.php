<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => "department1",
            'email'=> "department1@gmail.com",
            'phone'=>"12345678901",
            'description'=>"default department",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); //
    }
}
