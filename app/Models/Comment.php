<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    const COMMENTS_ACHIEVEMENTS = [
            1  => 'First Comment Written',
            3  => '3 Comments Written',
            5  => '5 Comments Written',
            10 => '10 Comments Written',
            20 => '20 Comments Written',
    ];

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'body',
            'user_id',
    ];

    /**
     * Get the user that wrote the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
