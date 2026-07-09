<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
{
    

    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isStaff());
    }

    

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'borrow_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }
}
