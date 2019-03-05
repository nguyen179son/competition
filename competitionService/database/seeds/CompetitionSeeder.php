<?php

use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('competition')->insert([
            'competition_id' => 1,
            'competition_name' => 'son',
            'host_id' => 1,
            'competition_description' => '123123',
            'background_picture' => 's3.eu-north-1.amazonaws.com/wonderdance/competition/155131206945496790_2180393252204172_8994356155769683968_n.jpg',
            'start_date' => '1997-10-10',
            'start_time' => '19:00:00',
            'end_date' => '1998-11-11',
            'end_time' => '19:30:00',
            'time_zone' => 'GMT+1',
            'address_name' => 'abc',
            'address_city' => 'uppsala',
            'address_state' => 'uppsala',
            'address_country' => 'sweden',
            'address_longitude' => 50.01,
            'address_latitude' => 50.01,
        ]);
        DB::table('competition')->insert([
            'competition_id' => 2,
            'competition_name' => 'son',
            'host_id' => 2,
            'competition_description' => '123123',
            'background_picture' => 'https://s3.eu-north-1.amazonaws.com/wonderdance/competition/155130454415PassList.png',
            'start_date' => '1997-10-10',
            'start_time' => '19:00:00',
            'end_date' => '1998-11-11',
            'end_time' => '19:30:00',
            'time_zone' => 'GMT+1',
            'address_name' => 'abc',
            'address_city' => 'uppsala',
            'address_state' => 'uppsala',
            'address_country' => 'sweden',
            'address_longitude' => 50.01,
            'address_latitude' => 50.01,
        ]);
        DB::table('competition')->insert([
            'competition_id' => 3,
            'competition_name' => 'son',
            'host_id' => 2,
            'competition_description' => '123123',
            'background_picture' => 'https://s3.eu-north-1.amazonaws.com/wonderdance/competition/155130454415PassList.png',
            'start_date' => '1997-10-10',
            'start_time' => '19:00:00',
            'end_date' => '1998-11-11',
            'end_time' => '19:30:00',
            'time_zone' => 'GMT+1',
            'address_name' => 'abc',
            'address_city' => 'uppsala',
            'address_state' => 'uppsala',
            'address_country' => 'sweden',
            'address_longitude' => 50.01,
            'address_latitude' => 50.01,
        ]);
        DB::table('competition')->insert([
            'competition_id' => 4,
            'competition_name' => 'son',
            'host_id' => 2,
            'competition_description' => '123123',
            'background_picture' => 'https://s3.eu-north-1.amazonaws.com/wonderdance/competition/155130454415PassList.png',
            'start_date' => '1997-10-10',
            'start_time' => '19:00:00',
            'end_date' => '1998-11-11',
            'end_time' => '19:30:00',
            'time_zone' => 'GMT+1',
            'address_name' => 'abc',
            'address_city' => 'uppsala',
            'address_state' => 'uppsala',
            'address_country' => 'sweden',
            'address_longitude' => 50.01,
            'address_latitude' => 50.01,
        ]);
    }
}
