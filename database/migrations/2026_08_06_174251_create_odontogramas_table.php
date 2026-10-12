<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontogramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontogramas', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->nullable();
            $table->foreignId('dente_id')->constrained('dentes')->cascadeOnDelete();
            $table->foreignId('estado_dente_id')->nullable()->constrained('estado_dentes')->nullOnDelete();
            $table->foreignId('procedimento_id')->nullable()->constrained('procedimentos_odontologicos')->nullOnDelete();
            $table->text('observacao')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('odontogramas');
    }
}
