<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class MaterialProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('material_product')->insert([
            'material_id' => 1,
            'product_id'=> 1,
            'quantity'=>100,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
