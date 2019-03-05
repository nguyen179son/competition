<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAddressColumnsCompetitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competition', function(Blueprint $table) {
            $table->renameColumn('city', 'address_city');
            $table->renameColumn('state', 'address_state');
            $table->renameColumn('country', 'address_country');
            $table->renameColumn('longitude', 'address_longitude');
            $table->renameColumn('latitude', 'address_latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
