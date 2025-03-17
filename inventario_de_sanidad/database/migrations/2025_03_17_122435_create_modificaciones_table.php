<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificacionesTable extends Migration
{
    public function up()
    {
        Schema::create('modificaciones', function (Blueprint $table) {
            $table->string('id_usuario', 40);
            $table->string('id_material', 40);
            $table->dateTime('fecha_accion');
            $table->enum('accion', ['sumar', 'restar']);
            $table->unsignedInteger('unidades');
            $table->enum('tipo_almacen', ['uso', 'reserva']);
            $table->primary(['id_usuario', 'id_material', 'fecha_accion']);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_material')->references('id_material')->on('materiales')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('modificaciones');
    }
}