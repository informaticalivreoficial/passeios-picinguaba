<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('passeio_id');
            $table->unsignedInteger('user_id');
            $table->string('status')->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->integer('id_gateway')->default('0');
            $table->string('status_gateway')->nullable();
            $table->integer('total_passageiros')->default('0');
            $table->date('data_compra')->nullable();
            $table->string('token')->nullable();

            $table->timestamps();

            $table->foreign('passeio_id')->references('id')->on('passeios')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
