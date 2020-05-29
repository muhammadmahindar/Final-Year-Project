<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemiFixedTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semi_fixeds')->insert([
            'name'         => 'Salaries wages and Other benefits-Factory',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('semi_fixeds')->insert([
            'name'         => 'Insurance',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('semi_fixeds')->insert([
            'name'         => 'Depreciation',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('semi_fixeds')->insert([
            'name'         => 'Power Consumed',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
