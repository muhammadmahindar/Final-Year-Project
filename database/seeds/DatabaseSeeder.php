<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(CompanyTableSeeder::class);
		$this->call(DepartmentTableSeeder::class);
		$this->call(BranchTableSeeder::class);    	
        $this->call(UsersTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(MaterialTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(MaterialProductTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
    }
}
