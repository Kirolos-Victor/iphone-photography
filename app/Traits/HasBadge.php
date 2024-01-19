<?php

namespace App\Traits;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasBadge
{
    public function getLatestUnlockedBadge(): Model|null
    {
        return $this->getUnlockedBadges()->latest()->first();
    }

    public function getUnlockedBadges(): HasMany
    {
        return $this->hasMany(Badge::class, 'user_id', 'id');
    }

}