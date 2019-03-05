<?php

use Illuminate\Database\Seeder;

class McSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mc')->insert([
            'mc_id' => 1,
            'category_id' => 1,
            'mc_name' => 'son',
        ]);

        DB::table('mc')->insert([
            'mc_id' => 2,
            'category_id' => 2,
            'mc_name' => 'son',
        ]);
        DB::table('mc')->insert([
            'mc_id' => 3,
            'category_id' => 3,
            'mc_name' => 'son',
        ]);
        DB::table('mc')->insert([
            'mc_id' => 4,
            'category_id' => 4,
            'mc_name' => 'son',
        ]);
        DB::table('mc')->insert([
            'mc_id' => 5,
            'category_id' => 5,
            'mc_name' => 'son',
        ]);
        DB::table('mc')->insert([
            'mc_id' => 6,
            'category_id' => 6,
            'mc_name' => 'son',
        ]);
    }
}
