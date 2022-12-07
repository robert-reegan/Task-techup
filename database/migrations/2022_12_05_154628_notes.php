<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if (!Schema::hasTable('notes')) {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('task_id')->unsigned();
            $table->string('subject')->nullable();
            $table->string('attachment');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
        });
        //}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
