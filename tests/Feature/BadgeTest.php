<?php

namespace Tests\Feature;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use App\Services\NextLockedBadge;
use App\Services\RemainingToUnlockNextBadge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBadge(): void
    {
        $badge = Badge::factory()->create();
        $this->assertDatabaseHas('badges', [
                'id'      => $badge->id,
                'name'    => $badge->name,
                'user_id' => $badge->user_id,
        ]);
    }

    public function testBadgeUnlockedEventHasCorrectProperties()
    {
        $user = User::factory()->create();

        $event = new BadgeUnlocked('Test Badge', $user);

        $this->assertInstanceOf(BadgeUnlocked::class, $event);
        $this->assertSame('Test Badge', $event->badgeName);
        $this->assertSame($user, $event->user);
    }

    public function testGettingNextLockedBadge()
    {
        $user = User::factory()->create();
        $nextLockedBadge = (new NextLockedBadge())->get($user);
        $this->assertEquals('Intermediate', $nextLockedBadge);
    }
    public function testRemainingToUnlockNextBadge()
    {
        $user = User::factory()->create();
        $remaining = (new RemainingToUnlockNextBadge())->get($user);
        $this->assertEquals(4, $remaining);
    }
}
