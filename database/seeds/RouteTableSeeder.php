<?php

use Illuminate\Database\Seeder;

class RouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\Route::getRoutes() as $route) {
            $name = $route->getName();
            if (!empty($name)) {
                factory(\App\Models\Route::class)->create([
                    'route_name' => $name
                ]);
            }

        }
    }
}
