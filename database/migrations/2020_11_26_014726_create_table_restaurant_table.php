<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_restaurante')->unsigned();
            $table->foreign('id_restaurante')->on('restaurants')->references('id');
            $table->integer('id_mesa')->unsigned();
            $table->foreign('id_mesa')->on('tables')->references('id');
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
        Schema::dropIfExists('table_restaurant');
    }
}
