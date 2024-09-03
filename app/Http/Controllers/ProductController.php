<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('Shop Owner'))
                $data = Product::where('store_id', auth()->user()->store_id)->get();
            else
                $data = null;

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {
                    return $data->category->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">';
                    $btn .= '<a href="' . route('products.edit', $row->id) . '" class="btn btn-primary btn edit mr-2"><i class="fa-solid fa-pencil"></i></a>';
                    $btn .= '<button class="btn btn-danger btn delete" data-id="' . $row['id'] . '"  onclick="checkDelete(' . $row['id'] . ')"><i class="fa-solid fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('image', function ($data) {
                    return '<img src="' . asset($data->image) . '" width="60px"/>';
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == 1) {
                        return '<input class="toggle-demo" type="checkbox" checked data-toggle="toggle" data-on="on" data-off="Off" data-onstyle="success" data-offstyle="danger" onchange="status(' . $data->id . ',0)">';
                    } else {
                        return '<input class="toggle-demo" type="checkbox" data-toggle="toggle" data-on="on" data-off="Off"" data-onstyle="success" data-offstyle="danger"  onchange="status(' . $data->id . ',1)">';
                    }
                })
                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }

        return view('products.index');
    }

    public function create()
    {
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        $Suppliers = Supplier::where('store_id', auth()->user()->store_id)->get();
        return view('products.create', compact('categories', 'Suppliers'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'price' => 'required',
            'original_price' => 'required',
            'stock' => 'required',
            'sku' => 'required',
            'status' => 'required',
            'unit' => 'required',
        ]);

        try {
            $path = '/images/product';
            if ($request->hasFile('image')) {
                $image_name = auth()->user()->store_id . time() . '.' . $request->image->extension();
                $request->image->move(public_path() . $path, $image_name);
                $image_path = $path . '/' . $image_name;
            }

            $product = Product::create([
                'name' => $request->name,
                'slug' => slug($request->name),
                'image' => $image_path,
                'description' => $request->description ?? null,
                'store_id' => auth()->user()->store_id,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'original_price' => $request->original_price,
                'discounted_price' => $request->discounted_price ?? $request->original_price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'status' => $request->status,
                'supplier_id' => $request->supplier_id,
                'subcategory_id' => $request->subcategory_id ?? null,
                'unit' => $request->unit ?? null,
                'discount_type' => $request->discount_type ?? null,
                'discount_value' => $request->discount_value ?? null,
            ]);


            // Fetch the supplier's name using the supplier ID
            $supplier = Supplier::find($request->supplier_id);

            // Create the expense
            Expense::create([
                'expense_date' => Carbon::now(),
                'expense_category' => "Product Buy " . ($supplier ? $supplier->name : 'Unknown Supplier'),
                'expense_amount' => $request->original_price * $request->stock,
                'store_id' => auth()->user()->store_id,
                'slug' => slug($request->name)
            ]);

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        $Suppliers  = Supplier::where('store_id', auth()->user()->store_id)->get();
        return view('products.edit', compact('product', 'categories', 'Suppliers'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'price' => 'required',
            'original_price' => 'required',
            'stock' => 'required',
            'sku' => 'required',
            'status' => 'required',
            'unit' => 'required',
        ]);

        try {
            $product = Product::find($id);
            $path = '/images/product';
            if ($request->hasFile('image')) {
                $old_image = $product->image;
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
                $image_name = auth()->user()->store_id . time() . '.' . $request->image->extension();
                $request->image->move(public_path() . $path, $image_name);
                $image_path = $path . '/' . $image_name;
            } else {
                $image_path = $product->image;
            }

            $product->update([
                'name' => $request->name,
                'image' => $image_path,
                'description' => $request->description ?? null,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'original_price' => $request->original_price,
                'discounted_price' => $request->discounted_price ?? null,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'status' => $request->status,
                'subcategory_id' => $request->subcategory_id ?? null,
                'unit' => $request->unit ?? null,
                'discount_type' => $request->discount_type ?? null,
                'discount_value' => $request->discount_value ?? null,
            ]);

            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
          try{
            $product = Product::find($id);
            $path = $product->image;
            if (file_exists($path)) {
                unlink($path);
            }
            $product->delete();
            return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
          }
          catch (\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
          }
    }


    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['status' => true, 'data' => $subcategories]);
    }


    public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        $product->update(['status' => $request->status]);
        return response()->json(['status' => true, 'message' => 'Status updated successfully']);
    }
}
