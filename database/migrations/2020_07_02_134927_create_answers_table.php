<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //"user_id","youth_id","question_id","value"
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("youth_id");
            $table->unsignedBigInteger("question_id");
            $table->string("value")->nullable();
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("youth_id")->references("id")->on("youths");
            $table->foreign("question_id")->references("id")->on("questions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
