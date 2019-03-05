<?php

use Illuminate\Database\Seeder;

class DjSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dj')->insert([
            'dj_id' => 1,
            'category_id' => 1,
            'dj_name' => 'son',
        ]);

        DB::table('dj')->insert([
            'dj_id' => 2,
            'category_id' => 2,
            'dj_name' => 'son',
        ]);
        DB::table('dj')->insert([
            'dj_id' => 3,
            'category_id' => 3,
            'dj_name' => 'son',
        ]);
        DB::table('dj')->insert([
            'dj_id' => 4,
            'category_id' => 4,
            'dj_name' => 'son',
        ]);
        DB::table('dj')->insert([
            'dj_id' => 5,
            'category_id' => 5,
            'dj_name' => 'son',
        ]);
        DB::table('dj')->insert([
            'dj_id' => 6,
            'category_id' => 6,
            'dj_name' => 'son',
        ]);
    }
}
