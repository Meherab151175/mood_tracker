<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Mood;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function moods()
    {
        return $this->hasMany(Mood::class);
    }

    public function hasConsecutiveMoods($days)
    {
        $latestMoods = $this->moods()
            ->orderBy('date', 'desc')
            ->take($days)
            ->get();

        if ($latestMoods->count() < $days) {
            return false;
        }

        $currentDate = now()->startOfDay();
        foreach ($latestMoods as $mood) {
            if ($mood->date->startOfDay()->ne($currentDate)) {
                return false;
            }
            $currentDate = $currentDate->subDay();
        }

        return true;
    }

    public function currentStreak()
    {
        $streak = 0;
        $currentDate = now()->startOfDay();
        
        while (true) {
            if (!$this->moods()->whereDate('date', $currentDate)->exists()) {
                break;
            }
            $streak++;
            $currentDate = $currentDate->subDay();
        }

        return $streak;
    }
}
