<?php

namespace App\Services;

use App\Actions\AvailableCommentAchievementAction;
use App\Actions\AvailableLessonAchievementAction;
use App\Models\User;

class NextAvailableAchievementService
{
    public function __construct(
            protected AvailableCommentAchievementAction $availableCommentAchievementAction,
            protected AvailableLessonAchievementAction $availableLessonAchievementAction
    ) {
    }

    public function get(User $user): array
    {
        return [
                'available_comments_achievements' => $this->availableCommentAchievementAction->get($user),
                'available_lessons_achievements'  => $this->availableLessonAchievementAction->get($user),
        ];
    }

}