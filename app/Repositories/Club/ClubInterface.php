<?php

namespace App\Repositories\Club;

interface ClubInterface
{
    public function getAll();

    public function getById(int $id);

    public function getPlayingMusic(int $id);

    public function getPlayList(int $id);

    public function getPlayMusicDance(int $id);

    public function getDancers(int $id, $value);

    public function getBarDrinkers(int $id, $value);

    public function updatePlayMusic(int $id, $musicId);
}
