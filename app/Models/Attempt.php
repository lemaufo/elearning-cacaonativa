<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attempt extends Model
{
    protected $fillable = [
        'user_id', 'quiz_id', 'score', 'passed',
        'blocked', 'unlocked_by_admin', 'started_at', 'finished_at',
    ];

    protected $casts = [
        'passed'             => 'boolean',
        'blocked'            => 'boolean',
        'unlocked_by_admin'  => 'boolean',
        'started_at'         => 'datetime',
        'finished_at'        => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }
}