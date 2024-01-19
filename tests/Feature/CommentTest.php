<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
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

   

}
