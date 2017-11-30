<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class GatePassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gate_passes')->insert([
            'person_name' => "altaf driver",
            'destination'=> "department1store",
            'contact_phone'=>"12345678901",
            'items'=>"Sheeda",
            'quantity'=>"12.54",
            'remarks'=>"default remarks",
            'created_at' =>Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' =>Carbon::now()->format('Y-m-d H:i:s'),
        ]);//
    }
}
