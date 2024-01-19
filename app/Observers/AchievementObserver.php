<?php

namespace App\Observers;

use App\Events\BadgeUnlocked;
use App\Models\Achievement;
use App\Models\Badge;

class AchievementObserver
{
    public function created(Achievement $achievement): void
    {
        $currentUser = $achievement->user;
        $achievementCount = $currentUser->getUnlockedAchievements->count();
        $badge = Badge::BADGES[$achievementCount] ?? null;

        if ($badge) {
            event(new BadgeUnlocked($badge, $currentUser));
        }
    }
}
