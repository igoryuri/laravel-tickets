<?php

namespace App\Http\Controllers;

use Adldap\Models\ModelNotFoundException;
use App\Events\NewTicket;
use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\Timeline;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where([
            ['user_id', '=', Auth::user()->id],
            ['status', '!=', '5']
        ])
            ->orderBy('id', 'desc')
            ->get();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = url()->previous();
        $categories = Category::all();
        $departments = Department::all();
        $users = User::all();

        return view('ticket.create', ['ticket' => new Ticket(), 'departments' => $departments, 'categories' => $categories, 'users' => $users, 'location' => $location]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['change'] = $request->change === 'on' ? 'on' : 'off';
        $image = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'pdf'];
        if ($image == null or in_array($image->extension(), $ext)) {
            $ticket = Ticket::create($request->all());
            broadcast(new NewTicket());
            session()->flash('success', 'Chamado criado com sucesso');
            $location = $request['location'];
            return redirect($location);
        } else {
            session()->flash('alert', 'Problema no envio da imagem, verifique a extensão');
            return redirect()->route('tickets.create');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        if ($status == '0') {
            $tickets = Ticket::where([
                ['user_id', '=', Auth::user()->id],
                ['status', '!=', '5']
            ])
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $tickets = Ticket::where([
                ['user_id', '=', Auth::user()->id],
                ['status', '=', $status]
            ])
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('ticket.show_table', compact('tickets', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Ticket::find($id);
        $categories = Category::find($ticket['category_id']);
        $users = User::all();
        $departments = Department::all();
        $location = url()->previous();
        if (!$ticket) {
            abort(404, 'Chamado não encotrado ou não existe!');
        }
        return view('ticket.edit', compact('ticket', 'categories', 'users', 'location', 'departments'));
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
        $request['change'] = $request->change === 'on' ? 'on' : 'off';
        $ticket = Ticket::find($id);
        $image = $request->file('image');
        $ext = ['jpg', 'jpeg', 'png', 'pdf'];
        if ($image == null or in_array($image->extension(), $ext)) {


            $ticket->update($request->all());
            session()->flash('success', 'Chamado editado com sucesso');
            $location = $request->input('location');
            return redirect($location);

        } else {

            session()->flash('alert', 'Problema no envio da imagem, verifique a extensão');
            return redirect()->route('tickets.create');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
