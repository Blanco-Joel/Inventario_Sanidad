<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->id('activity_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->text('description');
            $table->date('activity_date')->default(DB::raw('CURRENT_DATE'));

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');

            $table->index('activity_date', 'idx_activities_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
