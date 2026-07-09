<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $products = Product::query()
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->with('category')
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories', 'search', 'categoryId'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'location' => $request->location,
            'condition' => $request->condition,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'location' => $request->location,
            'condition' => $request->condition,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        
        $activeBorrowings = $product->borrowingDetails()
            ->whereHas('borrowing', function($q) {
                $q->whereIn('status', ['dipinjam', 'terlambat']);
            })->count();

        if ($activeBorrowings > 0) {
            return redirect()->route('products.index')->with('error', 'Barang tidak dapat dihapus karena sedang dipinjam.');
        }

        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus (soft delete).');
    }
}
