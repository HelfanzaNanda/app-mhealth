<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoverColumnOnPromosiKesehatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promosi_kesehatan', function (Blueprint $table) {
            $table->text('cover')->after('kategori_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promosi_kesehatan', function (Blueprint $table) {
            $table->dropColumn('cover');;
        });
    }
}
