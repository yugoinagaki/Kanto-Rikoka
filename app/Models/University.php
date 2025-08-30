<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name',
        'boys_league',
        'boys_rank',
        'girls_league',
        'girls_rank'
    ];
}
