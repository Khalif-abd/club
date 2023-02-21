<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubInfoResource extends JsonResource
{

    public static $wrap = 'club';

    public function toArray(Request $request): array
    {
        return [
            'id' => $this['club']->id,
            'name' => $this['club']->name,
            'playlist' => MusicResource::collection($this['playList']),
            'play_music' => new MusicResource($this['music']),
            'current_dance' => DanceSkillResource::collection($this['dance']),
            'total_dance_users' => $this['dancers']->count(),
            'dance_users' => UserResource::collection($this['dancers']),
            'total_bar_drinkers' => $this['barDrinkers']->count(),
            'bar_drinkers' => UserResource::collection($this['barDrinkers'])
        ];
    }
}
