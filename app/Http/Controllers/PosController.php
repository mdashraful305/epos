<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
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

    public function getCustomers(Request $request)
    {
        $search = $request->input('search');
        $data = Customer::select('id','name')
                ->where('store_id', auth()->user()->store_id)
                ->where('name','LIKE',"%{$search}%")
                ->orWhere('phone','LIKE',"%{$search}%")
                ->get();

        $results = $data->map(function($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json(['status' => true, 'results' => $results]);
  }
}
