<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Area extends Model
{
    protected $fillable = ['name', 'active'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function courses()
    {
        return Course::where('area', $this->name)->get();
    }
}