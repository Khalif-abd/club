<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\DanceSkill;
use App\Models\User;
use Illuminate\Database\Seeder;


class ClubUsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $users = User::query()->get('id');

        $club = Club::query()->first();

        $club->users()->attach($users);

    }
}
