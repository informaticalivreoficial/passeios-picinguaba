<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoteiroGbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roteiro_gbs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('roteiro_id');
            $table->string('path');
            $table->boolean('cover')->nullable();
            $table->boolean('marcadagua')->nullable();

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
        Schema::dropIfExists('roteiro_gbs');
    }
}
