<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $supervisor = Role::create(['name' => 'supervisor']);
        $vendedor = Role::create(['name' => 'vendedor']);
        $cliente = Role::create(['name' => 'cliente']);

        Permission::create(['name' => 'users'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'user.show'])->syncRoles([$admin]);


        Permission::create(['name' => 'profile.edit'])->syncRoles([$admin, $supervisor, $vendedor, $cliente]);
        Permission::create(['name' => 'profile.update'])->syncRoles([$admin, $supervisor, $vendedor, $cliente]);
        Permission::create(['name' => 'profile.destroy'])->syncRoles([$admin]);
    }
}
