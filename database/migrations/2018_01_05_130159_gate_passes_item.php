<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GatePassesItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('gate_passes_item', function (Blueprint $table) {
            $table->integer('gate_id')->unsigned();
            $table->string('itemname');
            $table->double('quantity', 15, 4)->default('0.0000');
            $table->foreign('gate_id')->references('id')->on('gate_passes')->onDelete('cascade');
            $table->timestamps();
        });  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gate_passes_item');//
    }
}
