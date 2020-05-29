<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            'name'       => 'Computer Department',
            'email'      => 'cd@gmail.com',
            'phone'      => '12345678901',
            'description'=> 'default department',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('departments')->insert([
            'name'       => 'Production Department',
            'email'      => 'cd@gmail.com',
            'phone'      => '12345678901',
            'description'=> 'default department',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
