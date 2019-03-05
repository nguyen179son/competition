<?php

use Illuminate\Database\Seeder;

class PrizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('prize')->insert([
            'prize_id' => 1,
            'category_id' => 1,
            'title' => 'son',
            'reward' => 'son',
        ]);

        DB::table('prize')->insert([
            'prize_id' => 2,
            'category_id' => 2,
            'title' => 'son',
            'reward' => 'son',
        ]);
        DB::table('prize')->insert([
            'prize_id' => 3,
            'category_id' => 3,
            'title' => 'son',
            'reward' => 'son',
        ]);
        DB::table('prize')->insert([
            'prize_id' => 4,
            'category_id' => 4,
            'title' => 'son',
            'reward' => 'son',
        ]);
        DB::table('prize')->insert([
            'prize_id' => 5,
            'category_id' => 5,
            'title' => 'son',
            'reward' => 'son',
        ]);
        DB::table('prize')->insert([
            'prize_id' => 6,
            'category_id' => 6,
            'title' => 'son',
            'reward' => 'son',
        ]);
    }
}
