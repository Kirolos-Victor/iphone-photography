<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_comment(): void
    {
        $comment = Comment::factory()->create();

        // Assert that the comment exists in the database
        $this->assertDatabaseHas('comments', [
                'id'      => $comment->id,
                'body'    => $comment->body,
                'user_id' => $comment->user_id,
        ]);
    }
}
