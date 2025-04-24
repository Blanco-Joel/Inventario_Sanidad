<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanidadSchema extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('id_usuario', 40)->primary();
            $table->string('nombre', 40);
            $table->string('apellidos', 60);
            $table->date('fecha_alta')->default(DB::raw('CURRENT_DATE'));
            $table->date('fecha_ultima_modificacion');
            $table->string('email', 100)->unique();
            $table->string('clave');
            $table->enum('tipo_usuario', ['alumno', 'docente', 'admin']);
        });

        Schema::create('materiales', function (Blueprint $table) {
            $table->string('id_material', 40)->primary();
            $table->string('nombre', 60);
            $table->string('descripcion', 100);
            $table->string('ruta_imagen', 100);
        });

        Schema::create('almacenamiento', function (Blueprint $table) {
            $table->string('id_material', 40);
            $table->enum('tipo_almacen', ['uso', 'reserva']);
            $table->unsignedInteger('armario');
            $table->unsignedInteger('balda');
            $table->unsignedInteger('unidades');
            $table->unsignedInteger('min_unidades');
            $table->primary(['id_material', 'tipo_almacen']);
            $table->foreign('id_material')->references('id_material')->on('materiales')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('modificaciones', function (Blueprint $table) {
            $table->string('id_usuario', 40);
            $table->string('id_material', 40);
            $table->enum('tipo_almacen', ['uso', 'reserva']);
            $table->dateTime('fecha_hora_accion');
            $table->integer('unidades');
            $table->primary(['id_usuario', 'id_material', 'tipo_almacen', 'fecha_hora_accion']);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign(['id_material', 'tipo_almacen'])->references(['id_material', 'tipo_almacen'])->on('almacenamiento')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('actividades', function (Blueprint $table) {
            $table->string('id_actividad', 40);
            $table->string('id_usuario', 40);
            $table->string('descripcion', 100);
            $table->date('fecha_alta')->default(DB::raw('CURRENT_DATE'));
            $table->primary(['id_actividad', 'id_usuario']);
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('material_actividad', function (Blueprint $table) {
            $table->string('id_actividad', 40);
            $table->string('id_material', 40);
            $table->unsignedInteger('cantidad');
            $table->primary(['id_actividad', 'id_material']);
            $table->foreign('id_actividad')->references('id_actividad')->on('actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_material')->references('id_material')->on('materiales')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_actividad');
        Schema::dropIfExists('actividades');
        Schema::dropIfExists('modificaciones');
        Schema::dropIfExists('almacenamiento');
        Schema::dropIfExists('materiales');
        Schema::dropIfExists('usuarios');
    }
}
