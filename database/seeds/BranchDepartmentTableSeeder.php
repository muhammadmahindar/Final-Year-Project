<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class BranchDepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('branch_department')->insert([
            'branch_id' => 1,
            'department_id'=> 1,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
