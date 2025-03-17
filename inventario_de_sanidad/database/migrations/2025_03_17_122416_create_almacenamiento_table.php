<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenamientoTable extends Migration
{
    public function up()
    {
        Schema::create('almacenamiento', function (Blueprint $table) {
            $table->string('id_material', 40);
            $table->enum('tipo_almacen', ['uso', 'reserva']);
            $table->unsignedInteger('armario');
            $table->unsignedInteger('balda');
            $table->unsignedInteger('unidades');
            $table->primary(['id_material', 'tipo_almacen']);
            $table->foreign('id_material')->references('id_material')->on('materiales')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacenamiento');
    }
}

