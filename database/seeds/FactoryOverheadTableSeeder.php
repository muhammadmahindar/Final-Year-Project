<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class FactoryOverheadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('factory_over_heads')->insert([
            'name'=>"Staff Welfare and Training",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'=>"Communication Charges",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
        DB::table('factory_over_heads')->insert([
            'name'=>"Printing Stationery and Office Supplies",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'=>"Other Manufacturing",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'=>"Outsourced Job Contractors",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  
        DB::table('factory_over_heads')->insert([
            'name'=>"Stores Spares & Loose Tools Consumed",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
        DB::table('factory_over_heads')->insert([
            'name'=>"Vehicle Running & Maintenance",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
        DB::table('factory_over_heads')->insert([
            'name'=>"Salaries Wages & Other Benefits",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]); 
        DB::table('factory_over_heads')->insert([
            'name'=>"Fuel and Power",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  
        DB::table('factory_over_heads')->insert([
            'name'=>"Repair & Maintenance",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);     
        DB::table('factory_over_heads')->insert([
            'name'=>"Travelling and Conveyance",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);                    
        DB::table('factory_over_heads')->insert([
            'name'=>"Chemicals",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);   
    }
}
