<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use PHPUnit\Framework\TestCase as Assert;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Administrador',
            'username' => 'administrador',
            'email' => 'admin@bioclin.com.br',
            'department_id' => '2',
            'password' => bcrypt('Senha123'),
            'access_level' => '1'
        ]);

//        $r = Artisan::call('adldap:import', ['--no-interaction']);
//        Assert::assertEquals(0, $r);
    }
}
