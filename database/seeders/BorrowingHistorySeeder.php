<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;

class BorrowingHistorySeeder extends Seeder
{
    

    public function run(): void
    {
        
        $users = User::whereHas('role', function($query) {
            $query->whereIn('name', ['staff', 'manager']);
        })->get();
        
        
        if ($users->isEmpty()) {
            $users = User::all();
        }
        
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Tabel users atau products masih kosong. Silakan jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        
        $currentYear = now()->year;
        $monthsToSeed = [2, 3, 4, 5, 6, 7]; 
        
        foreach ($monthsToSeed as $monthNum) {
            $baseDate = \Illuminate\Support\Carbon::create($currentYear, $monthNum, 1);
            
            
            $numBorrowings = rand(15, 25);
            
            for ($j = 0; $j < $numBorrowings; $j++) {
                $user = $users->random();
                
                
                if ($monthNum == now()->month && $currentYear == now()->year) {
                    $maxDay = now()->day;
                } else {
                    $maxDay = $baseDate->daysInMonth;
                }
                
                if ($maxDay < 1) $maxDay = 1;
                $day = rand(1, $maxDay);
                
                $borrowDate = $baseDate->copy()->day($day);
                
                
                $daysDiff = now()->diffInDays($borrowDate);
                
                if ($daysDiff < 7) {
                    
                    $status = rand(1, 10) <= 6 ? 'dipinjam' : 'dikembalikan';
                } else {
                    
                    $randVal = rand(1, 10);
                    if ($randVal <= 7) {
                        $status = 'dikembalikan';
                    } elseif ($randVal <= 9) {
                        $status = 'terlambat';
                    } else {
                        $status = 'dipinjam';
                    }
                }
                
                $returnDate = null;
                $conditionAfter = null;
                
                if ($status === 'dikembalikan') {
                    $returnDate = $borrowDate->copy()->addDays(rand(1, 10));
                    
                    if ($returnDate->isFuture()) {
                        $returnDate = now();
                    }
                    
                    $conditionAfter = rand(1, 10) <= 9 ? 'baik' : (rand(1, 2) == 1 ? 'rusak ringan' : 'rusak berat');
                }
                
                $borrowing = Borrowing::create([
                    'user_id' => $user->id,
                    'borrow_date' => $borrowDate->format('Y-m-d'),
                    'return_date' => $returnDate ? $returnDate->format('Y-m-d') : null,
                    'status' => $status,
                ]);
                
                
                $borrowedProducts = $products->random(rand(1, 3));
                foreach ($borrowedProducts as $product) {
                    BorrowingDetail::create([
                        'borrowing_id' => $borrowing->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 2),
                        'condition_after' => $conditionAfter,
                    ]);
                }
            }
        }
        
        $this->command->info('Seed data peminjaman selama 6 bulan terakhir berhasil ditambahkan!');
    }
}
