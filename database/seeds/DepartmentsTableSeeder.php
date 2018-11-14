<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Department::class)->create([
            'name' => 'Outros'
        ]);

        factory(Department::class)->create([
            'name' => 'TI'
        ]);

        factory(Department::class)->create([
            'name' => 'Controladoria'
        ]);

        factory(Department::class)->create([
            'name' => 'Operações'
        ]);
    }
}
