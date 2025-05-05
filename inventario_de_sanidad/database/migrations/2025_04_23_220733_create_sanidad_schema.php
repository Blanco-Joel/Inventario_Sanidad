<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanidadSchema extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('user_id');
            $table->string('first_name', 40);
            $table->string('last_name', 60);
            $table->timestamp('created_at')->useCurrent();
            $table->date('last_modified')->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('hashed_password');
            $table->boolean('firstLog');
            $table->enum('user_type', ['student', 'teacher', 'admin']);
        });

        Schema::create('materials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('material_id');
            $table->string('name', 60);
            $table->string('description', 100);
            $table->string('image_path', 100);
        });

        Schema::create('storage', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('material_id');
            $table->enum('storage_type', ['use', 'reserve']);
            $table->unsignedInteger('cabinet');
            $table->unsignedInteger('shelf');
            $table->unsignedInteger('units');
            $table->unsignedInteger('min_units');
            $table->primary(['material_id', 'storage_type']);
            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('modifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('material_id');
            $table->enum('storage_type', ['use', 'reserve']);
            $table->dateTime('action_datetime');
            $table->integer('units');
            $table->primary(['user_id', 'material_id', 'storage_type', 'action_datetime'], 'pk_modifications');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['material_id', 'storage_type'])->references(['material_id', 'storage_type'])->on('storage')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('activity_id');
            $table->unsignedInteger('user_id');
            $table->string('description', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('material_activity', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('activity_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('quantity');
            $table->primary(['activity_id', 'material_id']);
            $table->foreign('activity_id')->references('activity_id')->on('activities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_activity');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('modifications');
        Schema::dropIfExists('storage');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('users');
    }
}
