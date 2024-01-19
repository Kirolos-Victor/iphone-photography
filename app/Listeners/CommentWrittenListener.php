<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Comment;

class CommentWrittenListener
{
    public function handle(CommentWritten $event): void
    {
        $currentUser = $event->comment->user;
        $commentsCount = $currentUser->comments->count();
        $achievement = Comment::COMMENTS_ACHIEVEMENTS[$commentsCount] ?? null;
        if ($achievement) {
            event(new AchievementUnlocked($achievement, $currentUser, 'comment'));
        }
    }
}
