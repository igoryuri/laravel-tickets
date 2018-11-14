<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ticket extends Model
{
    use Notifiable;

    const STATUS_TICKET = [
        1 => 'Aberto',
        2 => 'Processando',
        3 => 'Pendente Fornecedor',
        4 => 'Pendente Cliente',
        5 => 'Fechado',
    ];

    const IMPACT_TICKET = [
        1 => 'Baixo',
        2 => 'Médio',
        3 => 'Alto',
    ];

    const URGENCY_TICKET = [
        1 => 'Baixo',
        2 => 'Médio',
        3 => 'Alto',
    ];

    const TYPE_TICKET = [
        1 => 'Incidente',
        2 => 'Requisição',
    ];


    protected $fillable = [
      'name', 'description', 'type', 'urgency', 'impact', 'image', 'status', 'change', 'user_id', 'category_id', 'change',
    ];
}
