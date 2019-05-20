<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakrpointTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markpoint', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('map_id')->index();
            $table->string('name');
            $table->float('latitude', 5, 2);
            $table->float('longitude', 5, 2);
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
        Schema::dropIfExists('markpoint');
    }
}
