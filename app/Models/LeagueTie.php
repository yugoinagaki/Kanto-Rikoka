<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeagueTie extends Model
{
    protected $fillable = [
        'league_id',
        'university_a_id',
        'university_b_id',
        'winner_university_id',
        'loser_university_id',
        'tie_date',
        'venue',
        'status'
    ];

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function universityA()
    {
        return $this->belongsTo(University::class, 'university_a_id');
    }

    public function universityB()
    {
        return $this->belongsTo(University::class, 'university_b_id');
    }

    public function winnerUniversity()
    {
        return $this->belongsTo(University::class, 'winner_university_id');
    }

    public function loserUniversity()
    {
        return $this->belongsTo(University::class, 'loser_university_id');
    }
}
