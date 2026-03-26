<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'course_id', 'title', 'min_score', 'max_attempts',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }

    public function attemptsFor(User $user): HasMany
    {
        return $this->attempts()->where('user_id', $user->id);
    }

    public function isBlockedFor(User $user): bool
    {
        $count = $this->attemptsFor($user)->count();
        $hasUnlock = $this->attemptsFor($user)
            ->where('unlocked_by_admin', true)->exists();

        return $count >= $this->max_attempts && !$hasUnlock;
    }
}