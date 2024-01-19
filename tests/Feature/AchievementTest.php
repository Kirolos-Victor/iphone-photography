<?php

namespace Tests\Feature;

use App\Events\AchievementUnlocked;
use App\Listeners\AchievementUnlockedListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    public function testAchievementUnlockedEventHasCorrectProperties()
    {
        $user = User::factory()->create();

        $event = new AchievementUnlocked('Test Achievement', $user, 'test');

        $this->assertInstanceOf(AchievementUnlocked::class, $event);
        $this->assertSame('Test Achievement', $event->achievementName);
        $this->assertSame($user, $event->user);
        $this->assertSame('test', $event->type);
    }
    public function testUnlockAchievementCreatesAchievement()
    {
        $user = User::factory()->create();
        $achievementName = 'Test Achievement';
        $type = 'test';

        $user->unlockAchievement($achievementName, $user, $type);

        $this->assertDatabaseHas('achievements', [
                'name'    => $achievementName,
                'user_id' => $user->id,
                'type'    => $type,
        ]);
    }
    public function testAchievementUnlockedListener()
    {
        Event::fake();

        $user = User::factory()->create();
        $event = new AchievementUnlocked('Test Achievement', $user, 'test');
        $listener = new AchievementUnlockedListener();

        $listener->handle($event);

        $this->assertDatabaseHas('achievements', [
                'name'    => 'Test Achievement',
                'user_id' => $user->id,
                'type'    => 'test',
        ]);
    }
}
