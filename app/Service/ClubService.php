<?php

namespace App\Service;

use App\Repositories\Club\ClubInterface;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ClubService
{

    protected ClubInterface $clubRepository;


    public function __construct(ClubInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }


    public function getAll(): Collection
    {
        return $this->clubRepository->getAll();
    }


    public function getClubInfo(int $clubId): array
    {
        return [
            'club' => $this->clubRepository->getById($clubId),
            'playList' => $this->getPlayList($clubId),
            'music' => $this->getPlayingMusic($clubId),
            'dance' => $this->getCurrentDance($clubId),
            'dancers' => $this->getDancers($clubId),
            'barDrinkers' => $this->getBarDrinkers($clubId),
        ];
    }


    public function getPlayList(int $clubId): Collection
    {
        return $this->clubRepository->getPlayList($clubId);
    }


    public function getPlayingMusic(int $clubId)
    {
        $playMusic = $this->clubRepository->getPlayingMusic($clubId);

        if (!$playMusic) {
            abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, 'Не указана композиция');
        }

        return $playMusic;
    }


    public function getCurrentDance(int $clubId): Collection
    {
        $music = $this->getPlayingMusic($clubId);

        return $music->danceSkills()->get();
    }


    public function changeMusic(int $clubId, int $musicId): bool
    {
        try {
            $this->clubRepository->updatePlayMusic($clubId, $musicId);
        } catch (\Exception) {
            abort(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, 'Не удалось обновить музыку');
        }

        return true;
    }


    public function getDancers(int $clubId): Collection
    {
        $skillsIds = $this->getCurrentDance($clubId);

        return $this->clubRepository->getDancers($clubId, $skillsIds->pluck('id'));
    }


    public function getBarDrinkers(int $clubId): Collection
    {
        $skillsIds = $this->getCurrentDance($clubId);

        return $this->clubRepository->getBarDrinkers($clubId, $skillsIds->pluck('id'));
    }


}
