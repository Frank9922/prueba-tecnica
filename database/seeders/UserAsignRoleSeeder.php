<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAsignRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::take(3)->get();

        $roles = Role::all();

        foreach ($users as $index => $user) {
            $user->roles()->attach($roles[$index]);
        }

        $fourthUser = User::skip(3)->first();
        if ($fourthUser) {
            $fourthUser->roles()->attach($roles);
        }
    }
}
