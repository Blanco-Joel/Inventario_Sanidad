<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_material', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->unsignedBigInteger('activity_id');
            $table->unsignedBigInteger('material_id');
            $table->unsignedInteger('quantity');
            $table->primary(['activity_id', 'material_id']);

            $table->foreign('activity_id')->references('activity_id')->on('activities')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('cascade')->onUpdate('cascade');

            $table->index('material_id', 'idx_activity_material_material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_material');
    }
}
