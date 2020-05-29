<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            'name'       => 'Multan Road',
            'email'      => 'mr@gmail.com',
            'phone'      => '12345678901',
            'address'    => 'xyz location',
            'description'=> 'default branch',
            'company_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]); //
    }
}
