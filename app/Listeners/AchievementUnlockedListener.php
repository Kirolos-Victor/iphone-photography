<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;

class AchievementUnlockedListener
{
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        $achievementName = $event->achievementName;

        // Update user's achievements logic
        $user->unlockAchievement($achievementName, $user, $event->type);
    }
}
