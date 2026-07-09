<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Http\Resources\BorrowingResource;
use Illuminate\Http\Request;

class BorrowingApiController extends Controller
{
    

    public function index(Request $request)
    {
        $borrowings = Borrowing::query()
            ->with(['user', 'details.product'])
            ->orderBy('borrow_date', 'desc')
            ->get();

        return BorrowingResource::collection($borrowings);
    }

    

    public function show(Borrowing $borrowing)
    {
        return new BorrowingResource($borrowing->load(['user', 'details.product']));
    }
}
