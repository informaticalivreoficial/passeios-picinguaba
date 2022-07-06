<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbarcacaoGbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embarcacao_gbs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('embarcacao_id');
            $table->string('path');
            $table->boolean('cover')->nullable();
            $table->boolean('marcadagua')->nullable();

            $table->timestamps();

            $table->foreign('embarcacao_id')->references('id')->on('embarcacoes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('embarcacao_gbs');
    }
}
