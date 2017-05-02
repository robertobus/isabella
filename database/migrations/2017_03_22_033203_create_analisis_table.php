<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analisis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paciente_id')->unsigned()->index();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->integer('medico_id')->unsigned()->index();
            $table->foreign('medico_id')->references('id')->on('medicos');
            $table->integer('obra_social_id')->nullable()->unsigned()->index();
            $table->foreign('obra_social_id')->references('id')->on('obra_social');
            $table->date('fecha');
            $table->string('diagnostico');
            $table->enum('grupo', ['A', 'B', 'AB', '0'])->nullable();
            $table->enum('factor', ['positivo', 'negativo'])->nullable();
            $table->enum('pci', ['positivo', 'negativo'])->nullable();
            $table->enum('pcd', ['positivo', 'negativo'])->nullable();
            $table->enum('ppt', ['positivo', 'negativo'])->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analisis');
    }
}
