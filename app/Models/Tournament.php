<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'starts_on',
        'ends_on',
        'year',
        'tournament_point_id',
    ];

    protected $casts = [
        'starts_on' => 'date',
        'ends_on' => 'date',
    ];
}