<?php

namespace Database\Seeders;

use App\Models\DanceSkill;
use App\Models\User;
use Illuminate\Database\Seeder;


class UserDanceSkillsSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $users = User::query()->get();

        foreach ($users as $user) {
            $rand = rand(0,3);

            $danceSkills = DanceSkill::query()
                ->inRandomOrder()->limit($rand)->get('id');

             $user->danceSkills()->attach($danceSkills);

        }
    }
}
