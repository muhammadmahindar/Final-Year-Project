<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class ProductProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('product_production')->insert([
            'product_id' => 1,
            'production_id'=> 1,
            'quantity'=>5,
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);  //
    }
}
