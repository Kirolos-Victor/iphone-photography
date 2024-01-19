<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\NextAvailableAchievementService;
use Illuminate\Http\JsonResponse;

class AchievementsController extends Controller
{
    public function __construct(
            protected NextAvailableAchievementService $nextAvailableAchievementService,
    ) {
    }

    public function index(User $user): JsonResponse
    {
        return response()->json([
                'unlocked_achievements'          => $user->getUnlockedAchievements,
                'next_available_achievements'    => $this->nextAvailableAchievementService->get($user),
                'current_badge'                  => $user->getLatestUnlockedBadge(),
                'next_badge'                     => '',
                'remaining_to_unlock_next_badge' => 0,
        ]);
    }
}
