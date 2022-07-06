<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbarcacaosTable extends Migration
{    
    public function up()
    {
        Schema::create('embarcacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');    
            $table->string('headline')->nullable();
            $table->integer('status')->default('0');
            $table->text('content')->nullable();
            $table->string('passageiros')->nullable();
            $table->string('tripulantes')->nullable();
            $table->string('comprimento')->nullable();
            $table->string('ano_de_construcao')->nullable();
            $table->string('slug')->nullable();
            $table->text('metatags')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('legendaimgcapa')->nullable();
            $table->boolean('exibirmarcadagua')->nullable();
            
            $table->timestamps();

        });
    }
    
    public function down()
    {
        Schema::dropIfExists('embarcacoes');
    }
}
