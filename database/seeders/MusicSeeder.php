<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\DanceSkill;
use App\Models\Music;
use Illuminate\Database\Seeder;


class MusicSeeder extends Seeder
{

    const musics = [
        [
            'name' => 'ATL',
            'author' => 'Марабу',
            'genre' => 'hip-hop',
            'dance_skills' => ['hip-hop'],
        ],
        [
            'name' => 'Dark Horse',
            'author' => 'Katy Perry',
            'genre' => 'rnb',
            'dance_skills' => ['rnb'],
        ],
        [
            'name' => 'Give It To Me',
            'author' => 'Timbaland',
            'genre' => 'electrohouse',
            'dance_skills' => ['electrodance'],
        ],
    ];

    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        foreach (self::musics as $music) {

            $res = Music::query()->create([
                'name' => $music['name'],
                'genre' =>  $music['genre'],
                'author' => $music['author'],
            ]);

            foreach ($music['dance_skills'] as $danceSkill) {
                $danceSkillId = DanceSkill::query()
                    ->where('name', $danceSkill)
                    ->first()->id;

                $res->danceSkills()->attach([$danceSkillId]);
            }
        }

        Club::query()->update(['play_music_id' => 1]);

    }
}
