<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class MaterialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('materials')->insert([
      		'material_code'=>str_random(10),
            'name' => "material1",
            'delete_status'=>1,
            'description'=>"material1 default",
            'user_id'=>1,
            'unit_id'=>1,
            'branch_id'=>1,
            'department_id'=>1,
            'company_id'=>1,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);//  //
    }
}
