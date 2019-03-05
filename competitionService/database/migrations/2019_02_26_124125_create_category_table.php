<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->unsignedInteger('competition_id');
            $table->string('description');
            $table->unsignedInteger('dance_genre_id');
            $table->integer('number_of_team_members');
            $table->integer('number_of_max_team');
            $table->string('fee_currency');
            $table->double('fee_amount');
            $table->foreign('competition_id')->references('competition_id')->on('competition');
            $table->softDeletes();
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
    }
}
