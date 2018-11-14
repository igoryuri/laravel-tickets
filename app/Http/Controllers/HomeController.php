<?php

namespace App\Http\Controllers;

use App\Models\Assign;
use App\Models\Category;
use App\Models\Department;
use App\Models\Solution;
use App\Models\Ticket;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticketsOpen = DB::table('tickets')
            ->leftJoin('assigns', 'tickets.id', '=', 'assigns.ticket_id')
            ->leftJoin('users', 'assigns.user_id', '=', 'users.id')
            ->leftJoin('users as us', 'tickets.user_id', '=', 'us.id')
            ->leftJoin('categories', 'tickets.category_id', '=', 'categories.id')
            ->leftJoin('departments', 'categories.department_id', '=', 'departments.id')
            ->where('categories.department_id', '=', Auth::user()->department_id)
            ->whereIn('tickets.status', [1, 2, 3, 4])
            ->select('tickets.*', 'assigns.id as userAssign', 'users.username as userName', 'us.name as ticketUserName', 'categories.name as cName', 'departments.name as dName')
            ->orderBy('tickets.id', 'desc')
            ->get();
        return view('dashboard.home', compact('ticketsOpen'));
    }

    public function getAjaxData()
    {
        $ticketsOpen = DB::table('tickets')
            ->leftJoin('assigns', 'tickets.id', '=', 'assigns.ticket_id')
            ->leftJoin('users', 'assigns.user_id', '=', 'users.id')
            ->leftJoin('users as us', 'tickets.user_id', '=', 'us.id')
            ->leftJoin('categories', 'tickets.category_id', '=', 'categories.id')
            ->leftJoin('departments', 'categories.department_id', '=', 'departments.id')
            ->where('categories.department_id', '=', Auth::user()->department_id)
            ->whereIn('tickets.status', [1, 2, 3, 4])
            ->select('tickets.*', 'assigns.id as userAssign', 'users.username as userName', 'us.name as ticketUserName', 'categories.name as cName', 'departments.name as dName')
            ->orderBy('tickets.id', 'desc')
            ->get();

        return view('dashboard.getAjaxData', compact('ticketsOpen'));
    }

    public function closed()
    {
        $ticketsOpen = DB::table('tickets')
            ->leftJoin('assigns', 'tickets.id', '=', 'assigns.ticket_id')
            ->leftJoin('users', 'assigns.user_id', '=', 'users.id')
            ->leftJoin('users as us', 'tickets.user_id', '=', 'us.id')
            ->leftJoin('categories', 'tickets.category_id', '=', 'categories.id')
            ->where('categories.department_id', '=', Auth::user()->department_id)
            ->whereIn('tickets.status', [5])
            ->select('tickets.*', 'assigns.id as userAssign', 'users.username as userName', 'us.name as ticketUserName')
            ->orderBy('tickets.id', 'desc')
            ->get();

        return view('dashboard.closed', compact('ticketsOpen'));
    }

}
