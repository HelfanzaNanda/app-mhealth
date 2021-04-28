<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasienRiwayatKontrasepsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien_riwayat_kontrasepsi', function (Blueprint $table) {
            $table->id();
            $table->integer('pasienid');
            $table->string('current_pregnancy');
            $table->string('before_current_pregnancy');
            $table->foreign('pasienid')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasien_riwayat_kontrasepsi');
    }
}
