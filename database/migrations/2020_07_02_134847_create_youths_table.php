<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYouthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("names")->nullable();
            $table->string("agent_no")->unique();
            $table->integer("age")->nullable();
            $table->string("ward")->nullable();
            $table->string("sub_county")->nullable();
            $table->string("county")->nullable();
            $table->string("school")->nullable();
            $table->string("form")->nullable();
            $table->string("gender")->nullable();
            $table->string("religion")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('youths');
    }
}
