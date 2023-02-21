<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use  HasFactory;

    const MAN = 1;
    const WOMAN = 2;

    protected $fillable = [
        'name',
        'gender',
    ];

    public function getGenderAttribute($value): string
    {
        $genders = [1 => 'male', 2 => 'female'];

        return $genders[$value] ?? '';
    }


    public function danceSkills(): BelongsToMany
    {
        return $this->belongsToMany(
            DanceSkill::class,
            'user_dance_skills',
            'user_id',
            'dance_id',
        );
    }


    public function scopeDancers($query, $values)
    {
        return $query->whereHas('danceSkills', function ($q) use ($values) {
            $q->whereIn('dance_id', $values);
        });
    }


    public function scopeBarDrinkers($query, $values)
    {
        return $query->whereDoesntHave('danceSkills', function ($q) use ($values) {
            $q->whereIn('dance_id', $values);
        });
    }

}
