<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('material_id');
            $table->enum('storage_type', ['use', 'reserve']);
            $table->dateTime('timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('quantity');
            $table->primary(['user_id', 'material_id', 'storage_type', 'timestamp']);

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['material_id', 'storage_type'])->references(['material_id', 'storage_type'])->on('storage')->onDelete('cascade')->onUpdate('cascade');

            $table->index('user_id', 'idx_modifications_user');
            $table->index('storage_type', 'idx_modifications_storage_type');
            $table->index('timestamp', 'idx_modifications_timestamp');
            $table->index(['user_id', 'timestamp'], 'idx_modifications_user_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modifications');
    }
}
