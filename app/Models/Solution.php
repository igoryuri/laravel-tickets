<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    protected $fillable = [
        'description', 'user_id', 'ticket_id', 'useful'
    ];
}
