<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Request;

class CheckDepartmentsArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = \Route::current()->getName();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $department = auth()->user()->department_id;

        $permissions = Permission::leftJoin('routes', 'permissions.route_id', '=', 'routes.id')
            ->select('permissions.*', 'routes.*')
            ->where('department_id', '=', $department)->get()->toArray();

        foreach ($permissions as $permission){
            if (in_array($route, $permission) and $permission['active'] == true){
                return $next($request);
            }
        }

        $url = url()->previous();
        return redirect($url);
    }
}
