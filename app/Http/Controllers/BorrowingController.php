<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Http\Requests\StoreBorrowingRequest;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        
        Borrowing::where('status', 'dipinjam')
            ->whereNull('return_date')
            ->where('borrow_date', '<', Carbon::today()->subDays(7))
            ->update(['status' => 'terlambat']);

        
        $search = $request->input('search');
        $status = $request->input('status');

        $borrowings = Borrowing::query()
            ->with(['user', 'details.product'])
            ->when($search, function($query, $search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('details.product', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->when($status, function($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('borrow_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('borrowings.index', compact('borrowings', 'search', 'status'));
    }

    public function export(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $borrowings = Borrowing::query()
            ->with(['user', 'details.product'])
            ->when($status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($search, function($query, $search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('details.product', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('borrow_date', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=laporan-peminjaman-" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Peminjaman', 'Nama Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status', 'Barang (Kode - Qty)'];

        $callback = function() use($borrowings, $columns) {
            $file = fopen('php://output', 'w');
            
            
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns);

            foreach ($borrowings as $borrowing) {
                $items = [];
                foreach ($borrowing->details as $detail) {
                    $items[] = $detail->product->name . " (" . $detail->product->code . " - " . $detail->quantity . "x)";
                }
                
                fputcsv($file, [
                    $borrowing->id,
                    $borrowing->user->name,
                    $borrowing->borrow_date->format('Y-m-d'),
                    $borrowing->return_date ? $borrowing->return_date->format('Y-m-d') : '-',
                    ucfirst($borrowing->status),
                    implode(', ', $items)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create()
    {
        $users = User::with('role')->get(); 
        $products = Product::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('users', 'products'));
    }

    public function store(StoreBorrowingRequest $request)
    {
        try {
            DB::beginTransaction();

            
            $borrowing = Borrowing::create([
                'user_id' => $request->user_id,
                'borrow_date' => $request->borrow_date,
                'status' => 'dipinjam',
            ]);

            
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok tidak mencukupi untuk barang: " . $product->name . " (Stok tersedia: " . $product->stock . ")");
                }

                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                ]);

                
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return redirect()->route('borrowings.index')->with('success', 'Transaksi peminjaman berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'details.product']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function returnProduct(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'conditions' => 'required|array',
            'conditions.*' => 'nullable|string|max:255',
        ]);

        if (in_array($borrowing->status, ['dikembalikan'])) {
            return redirect()->back()->with('error', 'Barang dari peminjaman ini sudah dikembalikan sebelumnya.');
        }

        try {
            DB::beginTransaction();

            $borrowing->update([
                'return_date' => Carbon::today(),
                'status' => 'dikembalikan',
            ]);

            foreach ($borrowing->details as $detail) {
                $product = $detail->product;

                
                $conditionAfter = $request->input('conditions.' . $detail->id) ?? 'baik';
                $detail->update([
                    'condition_after' => $conditionAfter
                ]);

                
                $product->increment('stock', $detail->quantity);

                
                if ($conditionAfter !== 'baik') {
                    $product->update([
                        'condition' => $conditionAfter
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
