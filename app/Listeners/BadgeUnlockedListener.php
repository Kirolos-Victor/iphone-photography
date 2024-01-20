<?php

namespace App\Listeners;

class BadgeUnlockedListener
{
    public function handle(object $event): void
    {
        $user = $event->user;
        $badgeName = $event->badgeName;

        // Update user's badge logic
        if ($user->getLatestUnlockedBadge()->name != $badgeName) {
            $user->unlockBadge($badgeName);
        }
    }
}
