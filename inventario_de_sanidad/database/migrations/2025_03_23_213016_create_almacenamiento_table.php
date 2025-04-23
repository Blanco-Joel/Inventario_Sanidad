<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenamientoTable extends Migration
{
    public function up()
    {
        Schema::create('almacenamiento', function (Blueprint $table) {
            $table->string('id_material', 40)->comment('Identificador del material');
            $table->enum('tipo_almacen', ['uso', 'reserva'])->comment('Tipo de almacenamiento');
            $table->unsignedInteger('armario')->comment('Número de armario');
            $table->unsignedInteger('balda')->comment('Número de balda');
            $table->unsignedInteger('unidades')->comment('Cantidad de unidades');
            $table->unsignedInteger('min_unidades')->comment('Cantidad mínima de unidades');
            $table->primary(['id_material', 'tipo_almacen']);
            $table->foreign('id_material')->references('id_material')->on('materiales')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacenamiento');
    }
}
