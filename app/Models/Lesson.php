<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    const LESSONS_ACHIEVEMENTS = [
            1  => 'First Lesson Watched',
            5  => '5 Lessons Watched',
            10 => '10 Lessons Watched',
            25 => '25 Lessons Watched',
            50 => '50 Lessons Watched',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'title',
    ];
}
