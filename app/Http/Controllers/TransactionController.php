<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $transaction = Transaction::with(['user', 'category'])->where('user_id', Auth::id())->get();
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'recurring_transaction_id' => 'required|exists:recurring_transactions,id',
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $transaction = Transaction::create($validated);

        return response()->json([
            'message' => 'Transaction Added successfully!',
            'data' => $transaction
        ], 200);
    }

    public function update($id,Request $request){
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'recurring_transaction_id' => 'sometimes|exists:recurring_transactions,id',
            'amount' => 'sometimes|numeric',
            'type' => 'sometimes|in:income,expense',
            'date' => 'sometimes|date',
            'description' => 'nullable|string|max:255',
        ]);

        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $transaction->update($validated);

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $transaction
        ], 200);
    }

    public function delete($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully',
        ], 200);
    }

}
