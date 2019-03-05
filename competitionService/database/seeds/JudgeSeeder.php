<?php

use Illuminate\Database\Seeder;

class JudgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('judge')->insert([
            'judge_id' => 1,
            'category_id' => 1,
            'judge_name' => 'son',
        ]);

        DB::table('judge')->insert([
            'judge_id' => 2,
            'category_id' => 2,
            'judge_name' => 'son',
        ]);
        DB::table('judge')->insert([
            'judge_id' => 3,
            'category_id' => 3,
            'judge_name' => 'son',
        ]);
        DB::table('judge')->insert([
            'judge_id' => 4,
            'category_id' => 4,
            'judge_name' => 'son',
        ]);
        DB::table('judge')->insert([
            'judge_id' => 5,
            'category_id' => 5,
            'judge_name' => 'son',
        ]);
        DB::table('judge')->insert([
            'judge_id' => 6,
            'category_id' => 6,
            'judge_name' => 'son',
        ]);
    }
}
