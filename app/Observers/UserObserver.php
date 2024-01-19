<?php

namespace App\Observers;

use App\Models\Badge;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        Badge::create([
                'user_id' => $user->id,
                'name'    => Badge::BADGES[0],
        ]);
    }
}
