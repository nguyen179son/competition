<?php

use Illuminate\Database\Seeder;

class dance_genre_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'BREAKING',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'LOCKING',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'POPPING',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'CHOREOGRAPHY',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'HIPHOP',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'HOUSE',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'KRUMP',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'WAACKING',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'FREESTYLE',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'JAZZ',
        ]);
        DB::table('dance_genre')->insert([
            'dance_genre_name' => 'DANCE_SPORT',
        ]);
    }
}
