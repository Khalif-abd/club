<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Music extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'genre',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    public function danceSkills(): BelongsToMany
    {
        return $this->belongsToMany(
            DanceSkill::class,
            'music_dance_skills',
            'music_id',
            'dance_id',
        );
    }

}
