<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInRujukan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rujukan', function (Blueprint $table) {
            $table->date('tanggal_rujukan')->after('faskesid');
            $table->string('no_surat')->after('tanggal_rujukan');
            $table->string('upload_surat')->after('no_surat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rujukan', function (Blueprint $table) {
            //
        });
    }
}
