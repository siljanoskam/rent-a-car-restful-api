<?php

use App\Enums\Roles;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            DB::table('role_user')->insert(
                [
                    'role_id' => Role::all()->random(1)->first()->id,
                    'user_id' => $user->id
                ]
            );
        }
    }
}
