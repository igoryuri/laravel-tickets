<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(DepartmentsTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(RouteTableSeeder::class);
         $this->call(PermissionTableSeeder::class);
//         $this->call(TicketsTableSeeder::class);
    }
}