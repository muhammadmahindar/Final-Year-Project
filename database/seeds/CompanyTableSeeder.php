<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => "company1",
            'email'=> "company1@gmail.com",
            'phone'=>"12345678901",
            'address'=>"xyz location",
            'description'=>"default company",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);//
    }
}
