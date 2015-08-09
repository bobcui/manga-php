<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageCountToWpWpmMngChpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_wpm_mng_chp', function (Blueprint $table) {
            $table->smallInteger('pageCount')->nullable()->default(null);
            $table->index('dte_upd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_wpm_mng_chp', function (Blueprint $table) {
             $table->dropColumn('pageCount');
             $table->dropIndex('wp_wpm_mng_chp_dte_upd_index');
        });
    }
}
