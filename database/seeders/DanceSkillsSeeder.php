<?php

namespace Database\Seeders;

use App\Models\DanceSkill;
use Illuminate\Database\Seeder;


class DanceSkillsSeeder extends Seeder
{

    const danceSkills = [
        ['name' => 'rnb'],
        ['name' => 'pop'],
        ['name' => 'hip-hop'],
        ['name' => 'electrodance'],
        ['name' => 'house'],
    ];

    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        foreach (self::danceSkills as $danceSkill) {
            DanceSkill::query()->create([
                'name' => $danceSkill['name']
            ]);
        }
    }
}
