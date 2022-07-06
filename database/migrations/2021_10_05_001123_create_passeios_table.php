<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasseiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passeios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('roteiro_id');
            $table->integer('status')->default('0');
            $table->boolean('venda')->nullable();
            $table->boolean('locacao')->nullable();
            $table->integer('vagas')->default('0');

            /** Valores Venda */ 
            $table->text('notasadicionais')->nullable();
            $table->integer('libera_venda')->default('0');
            $table->boolean('exibivalores_venda')->nullable();
            $table->decimal('valor_venda', 10, 2)->nullable();
            $table->decimal('valor_v_zerocinco', 10, 2)->nullable();
            $table->decimal('valor_v_seisdoze', 10, 2)->nullable();
            $table->decimal('valor_venda_promocional', 10, 2)->nullable();

            /** Valores Locação */
            $table->integer('libera_locacao')->default('0');
            $table->boolean('exibivalores_locacao')->nullable();
            $table->decimal('valor_locacao', 10, 2)->nullable();            
            $table->decimal('valor_locacao_promocional', 10, 2)->nullable();

            $table->string('saida')->nullable();
            $table->string('duracao')->nullable();

            /** Datas */
            $table->boolean('segunda')->nullable();
            $table->boolean('terca')->nullable();
            $table->boolean('quarta')->nullable();
            $table->boolean('quinta')->nullable();
            $table->boolean('sexta')->nullable();
            $table->boolean('sabado')->nullable();
            $table->boolean('domingo')->nullable();

            /** address */                       
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('num')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->integer('uf')->nullable();
            $table->integer('cidade')->nullable();

            $table->timestamps();

            $table->foreign('roteiro_id')->references('id')->on('roteiros')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passeios');
    }
}
