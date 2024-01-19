<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class RemainingToUnlockNextBadge
{
    public function get(User $user): int
    {
        $achievementsCount = $user->getUnlockedAchievements()->count();
        $badges = Badge::BADGES;
        $remaining = 0;
        foreach ($badges as $key => $badge) {
            if ($key > $achievementsCount) {
                $remaining = ($key - $achievementsCount);
                break;
            }
        }

        return $remaining;
    }

}