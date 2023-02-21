<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClubMusicRequest;
use App\Http\Resources\ClubInfoResource;
use App\Http\Resources\ClubResource;
use App\Http\Resources\MusicResource;
use App\Http\Resources\UserResource;
use App\Service\ClubService;

class ClubController extends Controller
{

    private ClubService $clubService;


    public function __construct(ClubService $clubService)
    {
        $this->clubService = $clubService;
    }


    public function index()
    {
        return ClubResource::collection($this->clubService->getAll());
    }


    public function show(int $clubId)
    {
        $clubInfo = $this->clubService->getClubInfo($clubId);

        return new ClubInfoResource($clubInfo);
    }


    public function playingMusic(int $clubId)
    {
        return new MusicResource($this->clubService->getPlayingMusic($clubId));
    }


    public function changeMusic(ClubMusicRequest $request, int $clubId)
    {
        $musicId = $request->input('music_id');

        $this->clubService->changeMusic($clubId, $musicId);

        return true;
    }


    public function dancers(int $clubId)
    {
        return UserResource::collection($this->clubService->getDancers($clubId));
    }


    public function barDrinkers(int $clubId)
    {
        return UserResource::collection($this->clubService->getBarDrinkers($clubId));
    }

}
