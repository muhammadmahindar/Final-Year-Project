<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('products')->insert([
      		'product_code'=>str_random(10),
            'name' => "product1",
            'delete_status'=>1,
            'description'=>"product1 default",
            'user_id'=>1,
            'unit_id'=>1,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
