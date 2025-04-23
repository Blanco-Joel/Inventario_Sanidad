<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificacionesTable extends Migration
{
    public function up()
    {
        Schema::create('modificaciones', function (Blueprint $table) {
            $table->string('id_usuario', 40)->comment('Identificador del usuario');
            $table->string('id_material', 40)->comment('Identificador del material');
            $table->enum('tipo_almacen', ['uso', 'reserva'])->comment('Tipo de almacenamiento modificado');
            $table->dateTime('fecha_hora_accion')->comment('Fecha y hora de la modificación');
            $table->enum('accion', ['sumar', 'restar'])->comment('Tipo de acción realizada');
            $table->unsignedInteger('unidades')->comment('Cantidad de unidades modificadas');
            $table->primary(['id_usuario', 'id_material', 'tipo_almacen', 'fecha_hora_accion']);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['id_material', 'tipo_almacen'])->references(['id_material', 'tipo_almacen'])->on('almacenamiento')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('modificaciones');
    }
}