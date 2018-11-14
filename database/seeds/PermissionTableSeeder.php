<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = \App\Models\Department::all();
        $routes = \App\Models\Route::all();
        foreach ($departments as $department){
            if ($department->id !== 2){
                foreach ($routes as $route) {
                    factory(Permission::class)->create([
                        'active' => false,
                        'route_id' => $route->id,
                        'department_id' => $department->id,
                    ]);
                }
            }else{
                foreach ($routes as $route) {
                    factory(Permission::class)->create([
                        'active' => true,
                        'route_id' => $route->id,
                        'department_id' => '2',
                    ]);
                }
            }
        }
    }
}
