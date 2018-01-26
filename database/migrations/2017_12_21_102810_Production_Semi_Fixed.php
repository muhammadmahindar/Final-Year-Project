<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductionSemiFixed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Production_Semi_Fixed', function (Blueprint $table) {
            $table->integer('semi_id')->unsigned();
            $table->integer('production_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('quantity', 15, 4)->default('0.0000');
            $table->foreign('semi_id')->references('id')->on('semi_fixeds')->onDelete('cascade');
            $table->foreign('production_id')->references('id')->on('productions')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('Production_Semi_Fixed');//
    }
}
