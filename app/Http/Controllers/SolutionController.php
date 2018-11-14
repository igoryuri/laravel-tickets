<?php

namespace App\Http\Controllers;

use App\Events\NewTicket;
use App\Events\RefreshPusherEvent;
use App\Models\Monitoring;
use App\Models\Solution;
use App\Models\Ticket;
use App\Models\Timeline;
use App\Notifications\TicketMail;
use App\User;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = Ticket::find($request['ticket_id']);
        $ticket->status = 5;
        $ticket->update();

        $user = User::find($ticket['user_id']);

        Solution::create($request->all());

        $data = Solution::all()->last()->toArray();
        $data['solution_id'] = $data['id'];
        Timeline::create($data);

        session()->flash('success', 'Solução criada');
        broadcast(new NewTicket());
        \Notification::send($user, new TicketMail("Chamado " . $ticket->name . " solucionado", $ticket->id));

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        $solutions = Solution::join('tickets', 'solutions.ticket_id', '=', 'tickets.id')
            ->where('tickets.category_id', '=', $ticket->category_id)
            ->whereRaw("tickets.name RLIKE '^[".$ticket->name."]'")
            ->select('tickets.id', 'tickets.name', 'tickets.description', 'solutions.description as sDescription', 'solutions.useful', 'solutions.id as sId')
            ->orderBy('solutions.useful', 'desc')
            ->get();
        $empty = $solutions->isEmpty();
        return view('solution.show', compact('solutions', 'empty'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $solution = Solution::find($id);
        $solution->update($request->all());

        return response()->json($solution);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
