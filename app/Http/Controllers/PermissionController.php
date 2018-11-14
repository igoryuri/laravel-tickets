<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Permission;
use App\Models\Route as MyRoute;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::leftJoin('departments', 'permissions.department_id', '=', 'departments.id')
            ->leftJoin('routes', 'permissions.route_id', '=', 'routes.id')
            ->select('permissions.*','departments.name', 'routes.route_name')
            ->orderBy('id', 'asc')
            ->get();
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes = MyRoute::all();
        $departments = Department::all();
        return view('permission.create', ['permission' => new Permission(), 'departments' => $departments, 'routes' => $routes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['active'] = $request->active === 'on' ? true : false;
        Permission::create($request->all());
        session()->flash('success', 'Permissão criada');
        return redirect()->route('permissions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $routes = MyRoute::all();
        $department = Department::find($id);
        $permissions = Permission::leftJoin('departments', 'permissions.department_id', '=', 'departments.id')
            ->leftJoin('routes', 'permissions.route_id', '=', 'routes.id')
            ->select('permissions.*','departments.name', 'routes.*')
            ->where('permissions.department_id', '=', $id)
            ->orderBy('route_name', 'asc')
            ->get();
//            dd($permissions);
            return view('permission.show', compact('permissions', 'routes', 'department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $routes = MyRoute::all();
        $departments = Department::all();
        $permission = Permission::find($id);

        return view('permission.edit', compact('permission', 'departments', 'routes'));
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
        $permission = Permission::find($id);

        $request['active'] = $request->active === 'on' ? true : false;

        $permission->update($request->all());

        return response()->json($permission);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            abort(404);
        }
        $permission->delete();
        session()->flash('success', 'Permissão removida');
        return redirect()->route('permissions.index');
    }
}
