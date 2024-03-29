<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    const BADGES = [
            0  => 'Beginner',
            4  => 'Intermediate',
            8  => 'Advanced',
            10 => 'Master',
    ];

    protected $fillable = ['user_id', 'name'];

    use HasFactory;
}
