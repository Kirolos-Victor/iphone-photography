<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasAchievement;
use App\Traits\HasBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasAchievement, HasBadge;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
            'name',
            'email',
            'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
            'password',
            'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }

    public function unlockAchievement(string $achievementName, string $type): void
    {
        Achievement::create([
                'name'    => $achievementName,
                'user_id' => $this->id,
                'type'    => $type,
        ]);
    }
    public function unlockBadge(string $badgeName): void
    {
        Badge::create([
                'name'    => $badgeName,
                'user_id' => $this->id,
        ]);
    }
}

