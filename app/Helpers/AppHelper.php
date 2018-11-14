<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Models\Permission;
use App\Models\Route as MyRoute;
use Illuminate\Support\Facades\Auth;

class AppHelper
{

    public static function checkAcessToButton($route_name)
    {
        $department_id = Auth::user()->department_id;
        $permission = Permission::leftJoin('routes', 'permissions.route_id', '=', 'routes.id')
            ->select('permissions.*', 'routes.*')
            ->where('route_name', '=', $route_name)
            ->where('department_id', '=', $department_id)->get()->toArray();
        if ($permission[0]['active'] == true){
            return '';
        }else{
            return 'hidden';
        }
    }

}