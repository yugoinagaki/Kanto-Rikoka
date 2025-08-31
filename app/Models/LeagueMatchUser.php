<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatchUser extends Model
{
    protected $fillable = [
        'league_match_id',
        'user_id',
        'side',
        'result'
    ];

    public function leagueMatch()
    {
        return $this->belongsTo(LeagueMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
