<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'day',
        'start',
        'end',
        'passed'
    ];

    // protected $casts = [
    //     'day' => 'datetime:Y-m-d',
    //     'start' => 'datetime',
    //     'end' => 'datetime',
    // ];


}
