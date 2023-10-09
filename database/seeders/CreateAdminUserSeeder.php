<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Santro',
            'email' => 'santro@gmail.com',
            'password' => bcrypt('password'),
            'is_super' => '1',
        ]);

        // $role = Role::create(['name' => 'SuperAdmin']);

        $permissions = Permission::pluck('id', 'id')->all();

        // $role->syncPermissions($permissions);
        $user->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
    }
}
