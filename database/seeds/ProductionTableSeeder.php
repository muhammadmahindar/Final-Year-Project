<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('productions')->insert([
            'production_code'=> str_random(10),
            'name'           => 'The name',
            'status'         => 1,
            'delete_status'  => 1,
            'description'    => 'production default',
            'branch_id'      => 1,
            'department_id'  => 1,
            'company_id'     => 1,
            'user_id'        => 1,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
