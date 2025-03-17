<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialesTable extends Migration
{
    public function up()
    {
        Schema::create('materiales', function (Blueprint $table) {
            $table->string('id_material', 40)->primary()->comment('Identificador del material');
            $table->string('nombre', 100)->comment('Nombre del material');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materiales');
    }
}