<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Music;
use Illuminate\Database\Seeder;


class ClubPlayListSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $musics = Music::query()->get('id');

        $club = Club::query()->first();

        $club->playlist()->attach($musics);
    }
}
