<?php

namespace App\Repositories\Club;

use App\Models\Club;


class ClubRepository implements ClubInterface
{

    protected Club $club;


    public function __construct(Club $club)
    {
        $this->club = $club;
    }



    public function getAll()
    {
        return $this->club->get();
    }


    public function getById(int $id)
    {

        return $this->club->where('id', $id)->firstOrFail();
    }


    public function getPlayingMusic(int $id)
    {
        $club = $this->getById($id);
        return $club->music()->first();
    }


    public function getPlayList(int $id)
    {
        $club = $this->getById($id);

        return $club->playlist()->get();
    }


    public function getPlayMusicDance(int $id)
    {
        $music = $this->getPlayingMusic($id);

        return $music->danceSkills()->get();
    }


    public function updatePlayMusic($id, $musicId)
    {
        $this->club->where('id', $id)->update(['play_music_id' => $musicId]);
    }


    public function getDancers(int $id, $value)
    {
        $club = $this->getById($id);

        return $club->users()->dancers($value)->get();
    }


    public function getBarDrinkers(int $id, $value)
    {
        $club = $this->getById($id);

        return $club->users()->barDrinkers($value)->get();
    }

}
