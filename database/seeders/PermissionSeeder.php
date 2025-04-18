<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    // ++++++++++++++++++++++++++
      // إنشاء الصلاحيات
      $permissions = [
        'manage users',
        'manage products',
        'manage orders',
        'view reports'
    ];

    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    // جلب الأدوار
    $superAdmin = Role::where('name', 'super-admin')->first();
    $admin = Role::where('name', 'admin')->first();
    $user = Role::where('name', 'user')->first();

    // إعطاء جميع الصلاحيات لـ Super Admin
    $superAdmin->givePermissionTo(Permission::all());

    // إعطاء صلاحيات محددة لـ Admin
    $admin->givePermissionTo(['manage users', 'manage products']);

    // إعطاء صلاحيات محددة لـ User (لا يحتاج أي صلاحية متقدمة)
    $user->givePermissionTo([]);


    // +++++++++++++++++++++++++++++
    }
}
