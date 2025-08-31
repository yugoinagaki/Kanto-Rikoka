<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPointRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade',
    ];

    public function tournamentPoints()
    {
        return $this->hasMany(TournamentPoint::class);
    }
}