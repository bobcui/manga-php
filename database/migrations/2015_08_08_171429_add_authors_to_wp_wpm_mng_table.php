<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorsToWpWpmMngTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_wpm_mng', function (Blueprint $table) {
            $table->json('authors')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_wpm_mng', function (Blueprint $table) {
             $table->dropColumn('authors');
        });
    }
}
