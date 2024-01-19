<?php

namespace App\Actions;

use App\Models\Comment;

class AvailableCommentAchievementAction
{
    public function get($user): array
    {
        $lastCommentAchievement = $user->getLatestUnlockedCommentAchievement();
        $commentAchievements = Comment::COMMENTS_ACHIEVEMENTS;

        if ($lastCommentAchievement) {
            $lastCommentKey = array_search($lastCommentAchievement->name, $commentAchievements, true);
            $achievements = [];
            foreach ($commentAchievements as $key => $commentAchievement) {
                if ($key > $lastCommentKey) {
                    $achievements[] = $commentAchievement;
                }
            }

            return $achievements;
        } else {
            return array_values($commentAchievements);
        }
    }

}