<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FactoryOverHeadProduction extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Factory_Ovear_head_Production', function (Blueprint $table) {
            $table->integer('factory_id')->unsigned();
            $table->integer('production_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->double('quantity', 15, 4)->default('0.0000');
            $table->foreign('factory_id')->references('id')->on('factory_over_heads')->onDelete('cascade');
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
        Schema::dropIfExists('Factory_Ovear_head_Production');//
    }
}
