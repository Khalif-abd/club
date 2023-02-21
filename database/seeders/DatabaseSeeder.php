<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(50)->create();
        Club::factory(1)->create();

        $this->call(DanceSkillsSeeder::class);
        $this->call(MusicSeeder::class);
        $this->call(UserDanceSkillsSeeder::class);
        $this->call(ClubUsersSeeder::class);
        $this->call(ClubPlayListSeeder::class);

    }
}
