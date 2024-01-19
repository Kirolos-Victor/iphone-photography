<?php

namespace App\Actions;

use App\Models\Lesson;

class AvailableLessonAchievementAction
{
    public function get($user): array
    {
        $lastLessonAchievement = $user->getLatestUnlockedLessonWatchedAchievement();
        $lessonAchievements = Lesson::LESSONS_ACHIEVEMENTS;

        if ($lastLessonAchievement) {
            $lastLessonKey = array_search($lastLessonAchievement->name, $lessonAchievements, true);
            $achievements = [];
            foreach ($lessonAchievements as $key => $lessonAchievement) {
                if ($key > $lastLessonKey) {
                    $achievements[] = $lessonAchievement;
                }
            }

            return $achievements;
        } else {
            return array_values($lessonAchievements);
        }
    }

}