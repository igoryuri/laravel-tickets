<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'name' => 'Falha de Software',
            'department_id' => '2'
        ]);

        factory(Category::class)->create([
            'name' => 'Sankhya',
            'department_id' => '3'
        ]);
    }
}
