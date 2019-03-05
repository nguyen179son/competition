<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(dance_genre_seeder::class);
        $this->call(CompetitionSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(DjSeeder::class);
        $this->call(McSeeder::class);
        $this->call(JudgeSeeder::class);
        $this->call(PrizeSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(TeamMemberSeeder::class);
    }
}
