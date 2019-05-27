<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDetailType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('card', function (Blueprint $table) {
            $table->text('detail')->change();
        });
        Schema::table('article', function (Blueprint $table) {
            $table->text('content')->change();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('card', function (Blueprint $table) {
            $table->string('detail')->change();
        });
        Schema::table('article', function (Blueprint $table) {
            $table->string('content')->change();
        });
    }
}
