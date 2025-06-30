<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mood extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'mood_type',
        'note',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getMoodOfTheMonth($userId)
    {
        return static::where('user_id', $userId)
            ->where('date', '>=', now()->subDays(30))
            ->select('mood_type', DB::raw('count(*) as total'))
            ->groupBy('mood_type')
            ->orderByDesc('total')
            ->first();
    }
}
