<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
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
            'name'=>"Salaries wages and Other benefits-Factory",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
         DB::table('semi_fixeds')->insert([
            'name'=>"Insurance",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
         DB::table('semi_fixeds')->insert([
            'name'=>"Depreciation",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  
          DB::table('semi_fixeds')->insert([
            'name'=>"Power Consumed",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
                
    }
}
