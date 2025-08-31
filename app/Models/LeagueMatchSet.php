<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatchSet extends Model
{
    protected $fillable = [
        'league_match_id',
        'set_number',
        'team_a_games',
        'team_b_games',
        'tiebreak_score',
        'is_retired'
    ];

    protected $casts = [
        'is_retired' => 'boolean'
    ];

    public function leagueMatch()
    {
        return $this->belongsTo(LeagueMatch::class);
    }
}
