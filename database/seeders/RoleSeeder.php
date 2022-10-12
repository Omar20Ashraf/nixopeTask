<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles = ['admin', 'staff','customer'];

        foreach($roles as $role):
            Role::create([
                'name' => $role,
                'display_name' => $role
            ]);
        endforeach;
    }
}
