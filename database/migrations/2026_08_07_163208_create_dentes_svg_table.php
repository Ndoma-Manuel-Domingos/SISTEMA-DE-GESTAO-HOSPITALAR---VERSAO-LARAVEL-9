<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentesSvgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentes_svg', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dente_id')->constrained('dentes')->cascadeOnDelete();
            $table->string('arquivo_svg');
            $table->string('svg_id')->nullable();
            $table->longText('conteudo_svg')->nullable();
            $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('dentes_svg');
    }
}
