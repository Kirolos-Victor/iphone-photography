<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class NextLockedBadge
{
    public function get(User $user): string
    {
        $lastUnlockedBadge = $user->getLatestUnlockedBadge();
        $badges = Badge::BADGES;

        if ($lastUnlockedBadge) {
            $lastUnlockedBadgeKey = array_search($lastUnlockedBadge->name, $badges, true);
            $nextBadgeName = '';
            foreach ($badges as $key => $badge) {
                if ($key > $lastUnlockedBadgeKey) {
                    $nextBadgeName = $badge;
                    break;
                }
            }

            return $nextBadgeName;
        } else {
            return $badges[0];
        }
    }

}