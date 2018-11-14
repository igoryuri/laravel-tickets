<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    protected $fillable = [
        'user_id', 'ticket_id'
    ];
}
