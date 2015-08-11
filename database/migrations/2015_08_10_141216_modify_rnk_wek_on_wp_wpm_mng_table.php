<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyRnkWekOnWpWpmMngTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_wpm_mng', function (Blueprint $table) {
            $table->integer('rnk_wek')->default(0x7FFFFFFF)->change();
            $table->index('rnk_wek');
        });

        DB::table('wp_wpm_mng')
            ->where('rnk_wek', '=', 0)
            ->update(['rnk_wek' => 0x7FFFFFFF]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_wpm_mng', function (Blueprint $table) {
            $table->integer('rnk_wek')->default(0)->change();
            $table->dropIndex('wp_wpm_mng_rnk_wek_index');
        });

        DB::table('wp_wpm_mng')
            ->where('rnk_wek', '=', 0x7FFFFFFF)
            ->update(['rnk_wek' => 0]);
    }
}
