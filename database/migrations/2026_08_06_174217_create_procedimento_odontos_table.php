<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcedimentoOdontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedimentos_odontologicos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('codigo', 20)->unique();
            $table->integer('duracao')->nullable();
            $table->decimal('valor', 10, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->text('descricao')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procedimentos_odontologicos');
    }
}
