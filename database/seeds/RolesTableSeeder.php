<?php

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Roles::all();

        foreach ($roles as $role) {
            DB::table('roles')->insert(
                [
                    'name' => $role
                ]
            );
        }
    }
}
