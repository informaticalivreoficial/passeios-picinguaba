<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoteirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roteiros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');    
            $table->string('headline')->nullable();
            $table->integer('status')->default('0');
            $table->boolean('venda')->nullable();
            $table->boolean('locacao')->nullable();                        
            
            /** Seo */
            $table->text('content')->nullable();
            $table->text('notasadicionais')->nullable();
            $table->string('slug')->nullable();
            $table->text('metatags')->nullable();
            $table->text('mapadogoogle')->nullable();
            $table->bigInteger('views')->default(0);
            $table->string('legendaimgcapa')->nullable();
            $table->boolean('exibirmarcadagua')->nullable();

            /** Valores Venda */ 
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
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roteiros');
    }
}
