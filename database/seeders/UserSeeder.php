<?php

namespace Database\Seeders;

use App\Models\Facturacion\Empresa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = User::factory()->create([
            'name' => 'Ing Alexander Barajas V',
            'email' => 'alexanderbarajas@gmail.com',
            'password'=>bcrypt('10203040'),
            'rol_id'=>1,
            'empresa_id'=>1,
        ])->assignRole('Superusuario');

        DB::table('empresa_user')
                        ->insert([
                            'empresa_id'    =>1,
                            'user_id'       =>$super->id,
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

        $id=1;

        while ($id <= 100) {

            $rol=Role::inRandomOrder()->first();
            $emp=Empresa::inRandomOrder()->first();

            $nuevo=User::factory()->create([
                            'rol_id'=>$rol->id,
                            'empresa_id'=>$emp->id
                        ])->assignRole($rol->name);

            DB::table('empresa_user')
                        ->insert([
                            'empresa_id'    =>$emp->id,
                            'user_id'       =>$nuevo->id,
                            'created_at'    =>now(),
                            'updated_at'    =>now()
                        ]);

            $id++;

        }
    }
}
