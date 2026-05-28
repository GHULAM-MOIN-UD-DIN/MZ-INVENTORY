<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SaleReturn;
use App\Models\Supplier;
use App\Models\Expense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Ensure/Create the single Admin user
        $admin = User::updateOrCreate(
            ['email' => 'moin69603@gmail.com'],
            [
                'name' => 'Ghulam Moin-Ud-Din',
                'password' => Hash::make('Moin@Farrokh123'),
                'role' => 'admin',
            ]
        );

        // 2. Delete all other users
        User::where('id', '!=', $admin->id)->delete();

        // 3. Delete all orphan data records belonging to other users
        Category::where('user_id', '!=', $admin->id)->delete();
        Customer::where('user_id', '!=', $admin->id)->delete();
        Product::where('user_id', '!=', $admin->id)->delete();
        Purchase::where('user_id', '!=', $admin->id)->delete();
        PurchaseItem::where('user_id', '!=', $admin->id)->delete();
        Sale::where('user_id', '!=', $admin->id)->delete();
        SaleItem::where('user_id', '!=', $admin->id)->delete();
        SaleReturn::where('user_id', '!=', $admin->id)->delete();
        Supplier::where('user_id', '!=', $admin->id)->delete();
        Expense::where('user_id', '!=', $admin->id)->delete();
    }
}
