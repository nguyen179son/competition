<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition', function (Blueprint $table) {
            $table->increments('competition_id');
            $table->string('competition_name');
            $table->integer('host_id');
            $table->string('competition_description');
            $table->string('background_picture');
            $table->date('start_date');
            $table->time('start_time');
            $table->date('end_date');
            $table->time('end_time');
            $table->string('time_zone');
            $table->string('address_name');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->double('longitude');
            $table->double('latitude');
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
