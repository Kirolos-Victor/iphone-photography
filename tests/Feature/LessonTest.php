<?php

namespace Tests\Feature;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateLesson(): void
    {
        $lesson = Lesson::factory()->create();

        $this->assertDatabaseHas('lessons', [
                'id'    => $lesson->id,
                'title' => $lesson->title,
        ]);
    }

    public function testLessonWatchedEventHasCorrectProperties()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();

        $event = new LessonWatched($lesson, $user);

        $this->assertInstanceOf(LessonWatched::class, $event);
        $this->assertSame($lesson, $event->lesson);
        $this->assertSame($user, $event->user);
    }
}
