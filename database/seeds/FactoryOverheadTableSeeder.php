<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            'name'         => 'Staff Welfare and Training',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Communication Charges',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Printing Stationery and Office Supplies',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Other Manufacturing',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Outsourced Job Contractors',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Stores Spares & Loose Tools Consumed',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Vehicle Running & Maintenance',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Salaries Wages & Other Benefits',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Fuel and Power',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Repair & Maintenance',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Travelling and Conveyance',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('factory_over_heads')->insert([
            'name'         => 'Chemicals',
            'delete_status'=> 1,
            'created_at'   => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'   => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
