<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRawrTrables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('description')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();

            $table->string('city')->nullable();
            $table->string('country')->nullable();

            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();

            $table->string('city')->nullable();
            $table->boolean('can_travel')->default(0);
            $table->boolean('premium')->default(0);
            $table->boolean('template_id')->default(0);

            $table->boolean('views')->default(0);

            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->unique();
            $table->integer('content_id')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default(1);
            $table->string('content_id')->default(1);
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->default(1);
            $table->string('content_id')->default(1);
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('content_id')->nullable();
            $table->string('type')->nullable();
            $table->string('link')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->string('type')->nullable();
            $table->string('link')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_from')->default(0);
            $table->integer('user_id_to')->default(0);
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('actions');
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('follows');
    }
}
