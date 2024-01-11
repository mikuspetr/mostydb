<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'editor', 'guard_name' => 'web'],
            ['name' => 'viewer', 'guard_name' => 'web'],
        ]);
        Permission::insert([
            ['name' => 'read', 'guard_name' => 'web'],
            ['name' => 'create', 'guard_name' => 'web'],
            ['name' => 'update', 'guard_name' => 'web'],
            ['name' => 'delete', 'guard_name' => 'web'],
            ['name' => 'edit users', 'guard_name' => 'web'],
            ['name' => 'edit users permisions', 'guard_name' => 'web'],
        ]);

        Role::findByName('admin')->syncPermissions(Permission::get());
        Role::findByName('editor')->syncPermissions(Permission::limit(4)->get());
        Role::findByName('viewer')->givePermissionTo(Permission::findByName('read'));

        \App\Models\User::find(4)->assignRole('admin');
    }
}
