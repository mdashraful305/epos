<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);

        $shop_owner=Role::create(['name' => 'Shop Owner']);
        $employee=Role::create(['name' => 'Employee']);

        $shop_owner->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'csrf-cookie-sanctuary',
            'load-cart-po',
            'add-to-cart-po',
            'request-password',
            'remove-cart-item-po',
            'clear',
            'route',
            'login',
            'logout',
            'register',
            'email-password',
            'update-password',
            'confirm-password',
            'reset-password',
            'dashboard',
            'profile-user',
            'show-user',
            'update-user',
            'destroy-user',
            'index-categories',
            'create-categories',
            'store-categories',
            'edit-categories',
            'update-categories',
            'destroy-categories',
            'index-subcategories',
            'create-subcategories',
            'store-subcategories',
            'edit-subcategories',
            'update-subcategories',
            'destroy-subcategories',
            'index-customer',
            'create-customer',
            'edit-customer',
            'update-customer',
            'destroy-customer',
            'index-product',
            'store-customer',
            'create-product',
            'store-product',
            'edit-product',
            'update-product',
            'destroy-product',
            'subcategories-product',
            'change-status-product',
            'create-store',
            'store-store',
            'show-store',
            'edit-store',
            'update-store',
            'destroy-store',
            'index-po',
            'subcategories-po',
            'products-po',
            'customers-po',
            'index-expense',
            'create-expense',
            'index-order',
            'update-expense',
            'destroy-expense',
            'edit-expense',
            'store-expense',
            'store-order',
            'edit-order',
            'create-order',
            'update-order',
            'destroy-order',
            'update-cart-item-po',
            'store-employee',
            'edit-employee',
            'update-employee',
            'getOrderData-order',
            'receipt-order',
            'index-supplier',
            'store-order',
            'edit-order',
            'edit-supplier',
            'orders-report',
            'update-supplier',
            'customer-report',
            'index-employee',
            'create-employee',
            'destroy-employee',
            'create-supplier',
            'store-supplier',
            'destroy-supplier',
            'index-report',
            'update-livewire',
            'customers-report'
        ]);

        $employee->givePermissionTo([
            
        ]);


    }
}
