<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Club extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'name',
        'play_music_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function music(): HasOne
    {
        return $this->hasOne(Music::class, 'id', 'play_music_id');
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'club_users',
            'club_id',
            'user_id',
        );
    }

    public function playlist(): BelongsToMany
    {
        return $this->belongsToMany(
            Music::class,
            'club_playlist',
            'club_id',
            'music_id',
        );
    }

}
