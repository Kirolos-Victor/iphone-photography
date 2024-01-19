<?php

namespace Tests\Feature;

use App\Actions\AvailableCommentAchievementAction;
use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateComment(): void
    {
        $comment = Comment::factory()->create();

        // Assert that the comment exists in the database
        $this->assertDatabaseHas('comments', [
                'id'      => $comment->id,
                'body'    => $comment->body,
                'user_id' => $comment->user_id,
        ]);
    }

    public function testCommentWrittenEvent()
    {
        $comment = Comment::factory()->create();

        $event = new CommentWritten($comment);

        $this->assertInstanceOf(CommentWritten::class, $event);
        $this->assertSame($comment, $event->comment);
    }

    public function testAchievementUnlockedEventIsFiredWhenCommentWritten()
    {
        Event::fake();

        $comment = Comment::factory()->create();
        $user = $comment->user;
        $listener = new CommentWrittenListener();

        $listener->handle(new CommentWritten($comment));

        $commentsCount = $user->comments->count();
        $achievement = Comment::COMMENTS_ACHIEVEMENTS[$commentsCount] ?? null;

        if ($achievement) {
            Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user, $achievement) {
                return $event->achievementName === $achievement
                        && $event->user === $user
                        && $event->type === 'comment';
            });
        } else {
            Event::assertNotDispatched(AchievementUnlocked::class);
        }
    }

    public function testAvailableCommentsAchievementsForNewUser()
    {
        $user = User::factory()->create();
        $availableCommentAchievements = (new AvailableCommentAchievementAction())->get($user);
        $expectedAchievements = array_values(Comment::COMMENTS_ACHIEVEMENTS);
        $this->assertEquals($expectedAchievements, $availableCommentAchievements);
    }

}
