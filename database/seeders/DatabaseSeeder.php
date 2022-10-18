<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // create permissions
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'delete products']);
        Permission::create(['name' => 'edit product']);
        Permission::create(['name' => 'list products']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // or may be done by chaining
        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo('list products');

    }
}
