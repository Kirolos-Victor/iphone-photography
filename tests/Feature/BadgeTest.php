<?php

namespace Tests\Feature;

use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
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
}
