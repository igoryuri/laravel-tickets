<?php

namespace App\Http\Controllers;

use App\Events\NewTicket;
use App\Models\Assign;
use App\Models\Ticket;
use App\Models\Timeline;
use App\User;
use App\Notifications\TicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AssignController extends Controller
{
    public function store(Request $request)
    {
        $ticket = Ticket::find($request['ticket_id']);
        $user = User::find($ticket['user_id']);
        $ticket->status = 2;
        $ticket->update();
        Assign::create($request->all());

        $data = Assign::all()->last()->toArray();
        $data['assign_id'] = $data['id'];
        Timeline::create($data);

        \Notification::send($user, new TicketMail(Auth::user()->name . " assumiu o seu chamado", $ticket['id']));
        session()->flash('success', 'Chamado atribuído à ' . Auth::user()->name);
        broadcast(new NewTicket());

        return back();
    }

    public function update(Request $request, $id)
    {
        //
    }
}
