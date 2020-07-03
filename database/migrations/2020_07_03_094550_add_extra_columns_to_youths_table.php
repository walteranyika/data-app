<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToYouthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youths', function (Blueprint $table) {
            $table->string("marital_status")->after("religion")->nullable();
            $table->string("highest_level")->after("marital_status")->nullable();
            $table->string("year_completion")->after("highest_level")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youths', function (Blueprint $table) {
            $table->dropColumn("marital_status");
            $table->dropColumn("highest_level");
            $table->dropColumn("year_completion");
        });
    }
}
