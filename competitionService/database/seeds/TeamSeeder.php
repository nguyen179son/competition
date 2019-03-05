<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('team')->insert([
            'team_id' => 1,
            'category_id' => 1,
            'user_id' => 1,
            'team_name' => 'son',
        ]);

        DB::table('team')->insert([
            'team_id' => 2,
            'category_id' => 2,
            'user_id' => 2,
            'team_name' => 'son',
        ]);
        DB::table('team')->insert([
            'team_id' => 3,
            'category_id' => 3,
            'user_id' => 3,
            'team_name' => 'son',
        ]);
        DB::table('team')->insert([
            'team_id' => 4,
            'category_id' => 4,
            'user_id' => 3,
            'team_name' => 'son',
        ]);
        DB::table('team')->insert([
            'team_id' => 5,
            'category_id' => 5,
            'user_id' => 2,
            'team_name' => 'son',
        ]);
        DB::table('team')->insert([
            'team_id' => 6,
            'category_id' => 6,
            'user_id' => 1,
            'team_name' => 'son',
        ]);
    }
}
