<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hashes', function (Blueprint $table) {
            $table->string('hash');
            $table->string('algorithm');
            $table->unsignedBigInteger('password_id');
            $table->foreign('password_id')->references('id')->on('passwords');
            $table->unique('hash', 'algorithm');
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
        Schema::dropIfExists('hashes');
    }
}
