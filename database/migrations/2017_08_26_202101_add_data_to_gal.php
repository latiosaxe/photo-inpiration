<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToGal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('ip')->nullable();
            $table->string('region')->nullable();
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->string('ip')->nullable();
            $table->string('region')->nullable();
        });
        Schema::create('searchs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('argument')->nullable();
            $table->string('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('region')->nullable();
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
        //
    }
}
