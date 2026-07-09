<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    

    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    

    public function rules(): array
    {
        $product = $this->route('product');
        $productId = $product ? $product->id : null;

        return [
            'code' => 'required|string|max:50|unique:products,code,' . $productId,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'location' => 'required|string|max:255',
            'condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
