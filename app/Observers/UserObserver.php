<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->unlockBadge(Badge::BADGES[0]);
    }
}
