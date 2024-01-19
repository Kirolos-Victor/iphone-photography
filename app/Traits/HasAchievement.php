<?php

namespace App\Traits;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasAchievement
{
    public function getLatestUnlockedCommentAchievement(): Model|null
    {
        return $this->getUnlockedAchievements()->where('type', '=', 'comment')->latest()->first();
    }

    public function getUnlockedAchievements(): HasMany
    {
        return $this->hasMany(Achievement::class, 'user_id', 'id');
    }

    public function getLatestUnlockedLessonWatchedAchievement(): Model|null
    {
        return $this->getUnlockedAchievements()->where('type', '=', 'lesson')->latest()->first();
    }
}