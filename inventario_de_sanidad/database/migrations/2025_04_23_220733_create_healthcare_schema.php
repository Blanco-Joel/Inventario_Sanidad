<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthcareSchema extends Migration
{
    public function up()
    {
        // users
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('user_id');
            $table->string('first_name', 40);
            $table->string('last_name', 60);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('hashed_password', 255);
            $table->boolean('first_log')->default(false);
            $table->enum('user_type', ['student', 'teacher', 'admin']);
            $table->timestamp('created_at')->useCurrent();
        });

        // materials
        Schema::create('materials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('material_id');
            $table->string('name', 60);
            $table->string('description', 100);
            $table->string('image_path', 255);
        });

        // storages
        Schema::create('storages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('material_id');
            $table->enum('storage',['odontology','CAE']);
            $table->enum('storage_type', ['use', 'reserve']);
            $table->string('cabinet', 30);
            $table->unsignedInteger('shelf');
            $table->unsignedInteger('drawer')->nullable();
            $table->unsignedInteger('units')->default(0);
            $table->unsignedInteger('min_units')->default(0);
            $table->primary(['material_id', 'storage_type']);

            $table->foreign('material_id')
                  ->references('material_id')->on('materials')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->index('material_id', 'idx_storages_material');
            $table->index('storage_type', 'idx_storages_type');
        });

        // modifications
        Schema::create('modifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('material_id');
            $table->enum('storage_type', ['use', 'reserve']);
            $table->dateTime('action_datetime');
            $table->integer('units');
            $table->primary(['user_id', 'material_id', 'storage_type', 'action_datetime'], 'pk_modifications');

            $table->foreign('user_id')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign(['material_id', 'storage_type'])
                  ->references(['material_id', 'storage_type'])->on('storages')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->index('user_id', 'idx_modifications_user');
            $table->index('storage_type', 'idx_modifications_storage_type');
            $table->index('action_datetime', 'idx_modifications_datetime');
            $table->index(['user_id', 'action_datetime'], 'idx_modifications_user_datetime');
        });

        // activities
        Schema::create('activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('activity_id');
            $table->unsignedInteger('user_id');
            $table->string('title', 100);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')
                  ->references('user_id')->on('users')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->index('created_at', 'idx_activities_created_at');
        });

        // material_activity
        Schema::create('material_activity', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('activity_id');
            $table->unsignedInteger('material_id');
            $table->unsignedInteger('units');
            $table->primary(['activity_id', 'material_id']);

            $table->foreign('activity_id')
                  ->references('activity_id')->on('activities')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('material_id')
                  ->references('material_id')->on('materials')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->index('material_id', 'idx_material_activity_material');
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_activity');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('modifications');
        Schema::dropIfExists('storages');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('users');
    }
}
