<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'name',
        'boys_division',
        'boys_rank',
        'girls_division',
        'girls_rank'
    ];
}
