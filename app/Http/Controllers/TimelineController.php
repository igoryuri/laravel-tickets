<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimelineController extends Controller
{
    public function show($id)
    {
        $ticket = DB::table('tickets')
        ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
        ->where('tickets.id', '=', $id)
        ->select('tickets.*', 'users.name as userName')
        ->get();

        $timelines = DB::table('timelines as tm')
            ->leftJoin('tickets as t', 't.id', '=', 'tm.ticket_id')
            ->leftJoin('users as u', 'u.id', '=', 'tm.user_id')
            ->leftJoin('departments as d', 'd.id', '=', 'tm.department_id')
            ->leftJoin('monitorings as m', 'm.id', '=', 'tm.monitoring_id')
            ->leftJoin('assigns as a', 'a.id', '=', 'tm.assign_id')
            ->leftJoin('solutions as s', 's.id', '=', 'tm.solution_id')
            ->leftJoin('users as us', 'us.id', '=', 'tm.user_id')
            ->where('t.id', '=', $id)
            ->orderBy('tm.id', 'asc')
            ->select('t.name as tName', 'u.name', 'd.name as dName', 'm.description as mDescription', 'us.name as aName')
            ->addSelect('s.description as sDescription', 'tm.assign_id', 'tm.monitoring_id as monitorId', 'tm.department_id as departId')
            ->addSelect('tm.solution_id as solutionId', 'tm.created_at as tmCreated', 'tm.id as tmId', 'tm.ticket_id as ticketId', 'tm.user_id as puserId')
            ->get();

//        dd($timelines, $ticket);

        return view('timeline.show', compact('ticket', 'timelines'));
    }
}
