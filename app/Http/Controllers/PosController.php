<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class PosController extends Controller
{

    public function index()
    {
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        return view('pos.index', compact('categories'));
    }


    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['status' => true, 'data' => $subcategories]);
    }
}
