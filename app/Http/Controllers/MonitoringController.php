<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Solution;
use App\Models\Timeline;
use App\User;
use App\Events\RefreshPusherEvent;
use App\Models\Monitoring;
use App\Models\Ticket;
use App\Notifications\TicketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ticket = Ticket::find($request->input('ticket_id'));
        $ticket->status = 2;
        $ticket->update();

        $ticket_user_id = (int)$ticket['user_id'];
        $auth_id = (int)$request->input('user_id');


        if ($auth_id == $ticket_user_id) {
            $assing = DB::table('assigns')->where('ticket_id', '=', $ticket->id)->get();
            if (!isset($assing[0])) {
                $category = DB::table('categories')->where('id', '=', $ticket->category_id)->get();
                $user = User::where('department_id', '=', $category[0]->department_id)->first();
            } else {
                $user = User::find($assing[0]->user_id);
            }
        } else {
            $user = User::find($ticket_user_id);
        }


        $monitoring = new Monitoring();
        $monitoring->description = $request->input('description');
        $monitoring->ticket_id = $request->input('ticket_id');
        $monitoring->user_id = \Auth::user()->id;
        $monitoring->save();

        $data = Monitoring::all()->last()->toArray();
        $data['monitoring_id'] = $data['id'];
        Timeline::create($data);

        \Notification::send($user, new TicketMail("Novo acompanhamento do chamado " . $ticket->name, $ticket->id));

        broadcast(new RefreshPusherEvent($monitoring));

        return response()->json($monitoring);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $monitorings = DB::table('monitorings')
            ->leftJoin('users', 'users.id', '=', 'monitorings.user_id')
            ->leftJoin('tickets', 'tickets.id', '=', 'monitorings.ticket_id')
            ->where('monitorings.ticket_id', '=', $id)
            ->orderBy('monitorings.id', 'desc')
            ->select('monitorings.*', 'users.name', 'tickets.user_id as userIdTicket')
            ->get()->toJson();

        return $monitorings;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function showPage($id)
    {
        $notification_id = filter_input(INPUT_GET, 'notId');
        $user = Auth::user();
        $ticket = Ticket::find($id);
        $assign = Assign::where('ticket_id', '=', $id)->get()->toArray();
        $solution = Solution::where('ticket_id', '=', $id)->get()->toArray();

        if (!empty($solution)){
            $solution = DB::table('solutions')
                ->leftJoin('users', 'users.id', '=', 'solutions.user_id')
                ->leftJoin('tickets', 'tickets.id', '=', 'solutions.ticket_id')
                ->where('solutions.ticket_id', '=', $id)
                ->orderBy('solutions.id', 'desc')
                ->select('solutions.*', 'users.name', 'tickets.user_id as userIdTicket')
                ->get()->toArray()[0];
        }

        if (!empty($assign)) {
            $assign = Assign::leftJoin('users', 'users.id', '=', 'assigns.user_id')
                ->where('ticket_id', '=', $id)
                ->select('users.name', 'assigns.id')
                ->get()->toArray()[0];
        }

        if (!empty($notification_id)) {
            $user->notifications->find($notification_id)->markAsRead();
        }

        return view('monitoring.show', compact('ticket', 'assign', 'solution'));
    }

}
