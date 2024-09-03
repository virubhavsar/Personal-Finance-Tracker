<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $categories = Category::where('user_id', Auth::id())->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|in:income,expense',
        ]);

        $validated['user_id'] = Auth::id();
        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $category
        ], 200);
    }

    public function update($id,Request $request){
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100',
            'type' => 'sometimes|in:income,expense',
        ]);

        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $category->update($validated);

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $category
        ], 200);
    }

    public function delete($id)
    {
        $category = Category::where('user_id', Auth::id())->find($id);

        if (!$category) {
            return response()->json(['error' => 'Record not found'], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
