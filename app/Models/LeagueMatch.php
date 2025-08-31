<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueMatch extends Model
{
    protected $fillable = [
        'league_tie_id',
        'slot_label',
        'competition_type',
        'format',
        'status'
    ];

    public function leagueTie()
    {
        return $this->belongsTo(LeagueTie::class);
    }
}
