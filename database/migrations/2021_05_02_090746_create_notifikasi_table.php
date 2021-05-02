<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->string('subject');
            $table->text('body');
            $table->enum('status', ['pending', 'sent', 'read']);
            $table->dateTime('created');
            $table->dateTime('sent')->nullable();
            $table->dateTime('read')->nullable();

            $table->foreign('userid')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi');
    }
}
