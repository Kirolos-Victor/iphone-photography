<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Lesson;

class LessonWatchedListener
{

    public function handle(LessonWatched $event): void
    {
        $currentUser = $event->user;
        $this->handleAttachLesson($currentUser, $event->lesson);
        $lessonsWatched = $currentUser->watched->count();
        $achievement = Lesson::LESSONS_ACHIEVEMENTS[$lessonsWatched] ?? null;
        if ($achievement) {
            event(new AchievementUnlocked($achievement, $currentUser, 'lesson'));
        }
    }

    private function handleAttachLesson($user, $lesson): void
    {
        if ($user->lessons()->wherePivot('lesson_id', $lesson->id)->exists()) {
            $user->lessons()->updateExistingPivot($lesson->id, ['watched' => true]);
        } else {
            $user->lessons()->attach($lesson, ['watched' => true]);
        }
    }
}
