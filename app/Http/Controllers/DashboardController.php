<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roleName = $user->role->name ?? 'staff';

        
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $activeBorrowingsCount = Borrowing::whereIn('status', ['dipinjam', 'terlambat'])->count();

        
        $itemsBorrowedCount = BorrowingDetail::whereHas('borrowing', function($q) {
            $q->whereIn('status', ['dipinjam', 'terlambat']);
        })->sum('quantity');

        
        $lowStockProducts = Product::where('stock', '<', 5)->get();

        
        $chartData = Borrowing::select(
            DB::raw('MONTHNAME(borrow_date) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('borrow_date', '>=', now()->subMonths(6))
        ->groupBy('month')
        ->orderBy(DB::raw('MIN(borrow_date)'))
        ->get();

        $months = $chartData->pluck('month')->toArray();
        $counts = $chartData->pluck('count')->toArray();

        
        if (empty($months)) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June'];
            $counts = [0, 0, 0, 0, 0, 0];
        }

        
        $data = compact(
            'totalProducts',
            'totalStock',
            'activeBorrowingsCount',
            'itemsBorrowedCount',
            'lowStockProducts',
            'months',
            'counts',
            'roleName'
        );

        
        if ($user->isAdmin()) {
            $data['totalCategories'] = Category::count();
            $data['totalUsers'] = User::count();
            $data['recentBorrowings'] = Borrowing::with(['user', 'details.product'])
                ->latest('borrow_date')
                ->take(5)
                ->get();
        } elseif ($user->isStaff()) {
            $data['myActiveBorrowings'] = Borrowing::where('user_id', $user->id)
                ->whereIn('status', ['dipinjam', 'terlambat'])
                ->count();
            $data['availableProducts'] = Product::where('stock', '>', 0)->count();
            $data['myReturnedBorrowings'] = Borrowing::where('user_id', $user->id)
                ->where('status', 'dikembalikan')
                ->count();
            $data['recentBorrowings'] = Borrowing::with(['user', 'details.product'])
                ->latest('borrow_date')
                ->take(5)
                ->get();
        } elseif ($user->isManager()) {
            $data['borrowingsThisMonth'] = Borrowing::whereMonth('borrow_date', now()->month)
                ->whereYear('borrow_date', now()->year)
                ->count();
            $totalBorrowings = Borrowing::count();
            $returnedBorrowings = Borrowing::where('status', 'dikembalikan')->count();
            $data['returnRate'] = $totalBorrowings > 0
                ? round(($returnedBorrowings / $totalBorrowings) * 100, 1)
                : 0;
        }

        return view('dashboard', $data);
    }
}
