<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'category_id' => 1,
            'competition_id' => 1,
            'description' => '123123',
            'dance_genre_id' => 1,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
        DB::table('category')->insert([
            'category_id' => 2,
            'competition_id' => 1,
            'description' => '123123',
            'dance_genre_id' => 2,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
        DB::table('category')->insert([
            'category_id' => 3,
            'competition_id' => 2,
            'description' => '123123',
            'dance_genre_id' => 3,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
        DB::table('category')->insert([
            'category_id' => 4,
            'competition_id' => 2,
            'description' => '123123',
            'dance_genre_id' => 5,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
        DB::table('category')->insert([
            'category_id' => 5,
            'competition_id' => 3,
            'description' => '123123',
            'dance_genre_id' => 6,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
        DB::table('category')->insert([
            'category_id' => 6,
            'competition_id' => 3,
            'description' => '123123',
            'dance_genre_id' => 7,
            'number_of_max_teams' => 10,
            'number_of_team_members' => 5,
            'fee_currency' => 'EUR',
            'fee_amount' => 1.1,
        ]);
    }
}
