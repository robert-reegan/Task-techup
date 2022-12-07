<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Task extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if (!Schema::hasTable('task')) {
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->string('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['New', 'Incomplete', 'Complete']);
            $table->enum('priority', ['Pending', 'Wait', 'Active']);
            $table->timestamps();
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
