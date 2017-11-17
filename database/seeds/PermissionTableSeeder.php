<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('permissions')->insert([
            'name' => "Permission1",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
