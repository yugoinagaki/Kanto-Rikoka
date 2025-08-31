<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_point_rule_id',
        'round',
        'points',
    ];

    public function tournamentPointRule()
    {
        return $this->belongsTo(TournamentPointRule::class);
    }
}