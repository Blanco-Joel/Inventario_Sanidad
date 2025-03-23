<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modificaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id_usuario', 40)->comment('Identificador del usuario');
            $table->string('id_material', 40)->comment('Identificador del material');
            $table->dateTime('fecha_accion')->comment('Fecha y hora de la modificación');
            $table->enum('tipo_almacen', ['uso', 'reserva'])->comment('Tipo de almacenamiento modificado');
            $table->enum('accion', ['sumar', 'restar'])->comment('Tipo de acción realizada');
            $table->unsignedInteger('unidades')->comment('Cantidad de unidades modificadas');
            $table->primary(['id_usuario', 'id_material', 'fecha_accion', 'tipo_almacen'],'pk_modificaciones');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['id_material', 'tipo_almacen'])->references(['id_material', 'tipo_almacen'])->on('almacenamiento')->onDelete('cascade')->onUpdate('cascade');
            $table->index('id_usuario', 'idx_modificaciones_usuario');
            $table->index('id_material', 'idx_modificaciones_material');
            $table->index('fecha_accion', 'idx_modificaciones_fecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modificaciones', function (Blueprint $table) {
            $table->dropIndex('idx_modificaciones_usuario');
            $table->dropIndex('idx_modificaciones_material');
            $table->dropIndex('idx_modificaciones_fecha');
        });

        Schema::dropIfExists('modificaciones');
    }
}
