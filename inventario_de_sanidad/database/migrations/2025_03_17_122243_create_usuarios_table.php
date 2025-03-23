<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('id_usuario', 40)->primary()->comment('Identificador del usuario');
            $table->string('nombre', 40)->comment('Nombre del usuario');
            $table->string('apellidos', 40)->comment('Apellidos del usuario');
            $table->date('fecha_alta')->comment('Fecha de alta del usuario');
            $table->enum('tipo_usuario', ['alumno', 'docente'])->comment('Tipo de usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
