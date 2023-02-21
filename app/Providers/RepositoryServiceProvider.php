<?php

namespace App\Providers;

use App\Repositories\Club\ClubInterface;
use App\Repositories\Club\ClubRepository;
use App\Repositories\Music\MusicInterface;
use App\Repositories\Music\MusicRepository;
use App\Repositories\User\UserInterface;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClubInterface::class, ClubRepository::class);
//        $this->app->bind(UserInterface::class, UserRepository::class);
//        $this->app->bind(MusicInterface::class, MusicRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
