<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logistica', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->bigIncrements('id');            
            $table->bigInteger('servicio_id')->unsigned();
    
            $table->string('nombre');
            $table->integer('pantallas');
            $table->string('celular');
            $table->integer('dias');
            $table->string('fecha_inicio');
            $table->string('fecha_vencimiento');
            $table->integer('decision');

            $table->integer('primer_aviso');
            $table->integer('segundo_aviso');
            $table->integer('corte_definitivo');

            $table->string('fecha_corte')->nullable();
            $table->integer('estado');
            $table->string('responsable');

            $table->timestamps();

            $table->foreign('servicio_id')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logistica');
    }
};
