<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    

    public function run(): void
    {
        
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);
        $managerRole = Role::create(['name' => 'manager']);

        
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@telkomsel.id',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@telkomsel.id',
            'password' => Hash::make('password'),
            'role_id' => $staffRole->id,
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@telkomsel.id',
            'password' => Hash::make('password'),
            'role_id' => $managerRole->id,
        ]);

        
        $elektronik = Category::create(['name' => 'Elektronik']);
        $atk = Category::create(['name' => 'Alat Tulis Kantor']);
        $furnitur = Category::create(['name' => 'Furnitur']);

        
        Product::create([
            'code' => 'PRD-001',
            'name' => 'Laptop ASUS ROG',
            'category_id' => $elektronik->id,
            'stock' => 10,
            'location' => 'Gudang A - Rak 1',
            'condition' => 'baik',
        ]);

        Product::create([
            'code' => 'PRD-002',
            'name' => 'Proyektor Epson EB-X05',
            'category_id' => $elektronik->id,
            'stock' => 5,
            'location' => 'Gudang A - Rak 2',
            'condition' => 'baik',
        ]);

        Product::create([
            'code' => 'PRD-003',
            'name' => 'Spidol Boardmarker Hitam',
            'category_id' => $atk->id,
            'stock' => 50,
            'location' => 'Laci Staff 1',
            'condition' => 'baik',
        ]);

        Product::create([
            'code' => 'PRD-004',
            'name' => 'Kursi Ergonomis',
            'category_id' => $furnitur->id,
            'stock' => 20,
            'location' => 'Ruang Kerja Utama',
            'condition' => 'baik',
        ]);

        Product::create([
            'code' => 'PRD-005',
            'name' => 'Meja Kerja Kayu',
            'category_id' => $furnitur->id,
            'stock' => 15,
            'location' => 'Ruang Rapat 2',
            'condition' => 'baik',
        ]);

        
        $staffUser = User::where('email', 'staff@telkomsel.id')->first();
        $productRog = Product::where('code', 'PRD-001')->first();
        $productSpidol = Product::where('code', 'PRD-003')->first();

        $borrowing1 = \App\Models\Borrowing::create([
            'user_id' => $staffUser->id,
            'borrow_date' => now()->subDays(5)->format('Y-m-d'),
            'return_date' => now()->format('Y-m-d'),
            'status' => 'dikembalikan',
        ]);

        \App\Models\BorrowingDetail::create([
            'borrowing_id' => $borrowing1->id,
            'product_id' => $productRog->id,
            'quantity' => 1,
            'condition_after' => 'baik',
        ]);

        $borrowing2 = \App\Models\Borrowing::create([
            'user_id' => $staffUser->id,
            'borrow_date' => now()->subDays(2)->format('Y-m-d'),
            'return_date' => null,
            'status' => 'dipinjam',
        ]);

        \App\Models\BorrowingDetail::create([
            'borrowing_id' => $borrowing2->id,
            'product_id' => $productSpidol->id,
            'quantity' => 5,
            'condition_after' => null,
        ]);
    }
}
