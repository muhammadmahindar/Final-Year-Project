<?php

use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('role_has_permissions')->insert([
            'role_id' => 1,
            'permission_id'=> 1,
        ]);  //
    }
}
