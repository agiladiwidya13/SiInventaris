<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'borrower' => [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? null,
                'email' => $this->user->email ?? null,
            ],
            'borrow_date' => $this->borrow_date->format('Y-m-d'),
            'return_date' => $this->return_date ? $this->return_date->format('Y-m-d') : null,
            'status' => $this->status,
            'items' => $this->details->map(fn($detail) => [
                'product_id' => $detail->product_id,
                'product_code' => $detail->product->code ?? null,
                'product_name' => $detail->product->name ?? null,
                'quantity' => $detail->quantity,
                'condition_after' => $detail->condition_after,
            ]),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
