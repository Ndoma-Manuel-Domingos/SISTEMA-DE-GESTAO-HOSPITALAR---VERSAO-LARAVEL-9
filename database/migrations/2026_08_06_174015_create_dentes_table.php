<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_denticao_id')->constrained('tipo_denticaos')->cascadeOnDelete();
            $table->string('codigo_fdi')->unique();
            $table->string('nome', 150);
            $table->enum('quadrante', ['Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8']);
            $table->enum('arcada', ['Superior', 'Inferior']);
            $table->enum('lado', ['Direito', 'Esquerdo']);
            $table->enum('sexo', [
                'Masculino',
                'Feminino',
                'Ambos'
            ])->default('Ambos');
            $table->string('imagem_svg')->nullable();
            $table->unsignedTinyInteger('ordem');
            $table->string('svg_id');
            $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('dentes');
    }
}
