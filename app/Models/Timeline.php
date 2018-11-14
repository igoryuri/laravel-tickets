<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_id',
        'group_id',
        'assign_id',
        'monitoring_id',
        'solution_id',
    ];
}
