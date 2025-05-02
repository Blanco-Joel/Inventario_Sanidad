<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->unsignedBigInteger('material_id');
            $table->enum('storage_type', ['use', 'reserve']);
            $table->unsignedInteger('cabinet');
            $table->unsignedInteger('shelf');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('min_quantity');
            $table->primary(['material_id', 'storage_type']);

            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('cascade')->onUpdate('cascade');

            $table->index('material_id', 'idx_storage_material');
            $table->index('storage_type', 'idx_storage_type');
            $table->index(['quantity', 'min_quantity'], 'idx_storage_quantities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storagephp');
    }
}
