<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('semi_id')->unsigned();
            $table->integer('factoryoverhead_id')->unsigned();
            $table->double('semi_amount', 15, 4);
            $table->double('factory_amount', 15, 4);
            $table->foreign('semi_id')->references('id')->on('semi_fixeds')->onDelete('cascade');
            $table->foreign('factoryoverhead_id')->references('id')->on('factory_over_heads')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('other_costs');
    }
}
