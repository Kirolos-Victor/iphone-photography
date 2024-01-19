<?php

namespace Tests\Feature;

use App\Actions\AvailableLessonAchievementAction;
use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Listeners\LessonWatchedListener;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
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

    public function testAchievementUnlockedEventIsFiredWhenLessonIsWatched()
    {
        Event::fake();
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $event = new LessonWatched($lesson, $user);
        $listener = new LessonWatchedListener();

        $listener->handle($event);

        $lessonsWatched = $user->watched->count();
        $achievement = Lesson::LESSONS_ACHIEVEMENTS[$lessonsWatched] ?? null;

        if ($achievement) {
            Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user, $achievement) {
                return $event->achievementName === $achievement
                        && $event->user === $user
                        && $event->type === 'lesson';
            });
        } else {
            Event::assertNotDispatched(AchievementUnlocked::class);
        }
    }
    public function testAvailableLessonsAchievementsForNewUser()
    {
        $user = User::factory()->create();
        $availableLessonAchievements = (new AvailableLessonAchievementAction())->get($user);
        $expectedAchievements = array_values(Lesson::LESSONS_ACHIEVEMENTS);
        $this->assertEquals($expectedAchievements, $availableLessonAchievements);
    }
}
