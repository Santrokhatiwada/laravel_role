<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
        $table->string('task_name');
        $table->text('description');
        $table->enum('status', ['pending', 'completed','approved','denied'])->default('pending');
        $table->unsignedBigInteger('assigner_id')->nullable();
        $table->timestamps();


        $table->foreign('assigner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
