<?php

use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('team_member')->insert([
            'member_id' => 1,
            'team_id' => 1,
            'member_name' => 'son',
        ]);

        DB::table('team_member')->insert([
            'member_id' => 2,
            'team_id' => 2,
            'member_name' => 'son',
        ]);
        DB::table('team_member')->insert([
            'member_id' => 3,
            'team_id' => 3,
            'member_name' => 'son',
        ]);
        DB::table('team_member')->insert([
            'member_id' => 4,
            'team_id' => 4,
            'member_name' => 'son',
        ]);
        DB::table('team_member')->insert([
            'member_id' => 5,
            'team_id' => 5,
            'member_name' => 'son',
        ]);
        DB::table('team_member')->insert([
            'member_id' => 6,
            'team_id' => 6,
            'member_name' => 'son',
        ]);
    }
}
