<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $budgets = Budget::with(['user','category'])->where('user_id', Auth::id())->get();
        return response()->json($budgets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'repeat_every_month' =>'required'
        ]);

        $validated['user_id'] = Auth::id();
        $budgets = Budget::create($validated);

        return response()->json([
            'message' => 'Budget Added successfully!',
            'data' => $budgets
        ], 200);
    }

    public function update($id,Request $request){
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'repeat_every_month' =>'required'
        ]);

        $budgets = Budget::where('user_id', Auth::id())->find($id);

        if (!$budgets) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $budgets->update($validated);

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $budgets
        ], 200);
    }

    public function delete($id)
    {
        $budgets = Budget::where('user_id', Auth::id())->find($id);
        if (!$budgets) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $budgets->delete();

        return response()->json([
            'message' => 'Budget deleted successfully',
        ], 200);
    }


    public function BudgetCategoryFetch()
    {
        $categories = Category::where('user_id', Auth::id())->where('type','expense')->get();
        return response()->json($categories);
    }

}
