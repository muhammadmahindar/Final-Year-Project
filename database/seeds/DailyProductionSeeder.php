<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DailyProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daily_production')->insert([
            'product_id'=>1,
            'produced'=>0.5421,
            'dispatches' =>0.0000,
            'sale_return'=>0.1,
            'received'=>0.5,
            'branch_id'=>1,
            'department_id'=>1,
            'company_id'=>1,
            'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('daily_production')->insert([
            'product_id'=>1,
            'produced'=>10.5421,
            'dispatches' =>2.0000,
            'sale_return'=>1.1,
            'received'=>3.5,
            'branch_id'=>1,
            'department_id'=>1,
            'company_id'=>1,
            'created_at'=>Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::yesterday()->format('Y-m-d H:i:s'),
        ]);
    }
}
