<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner'))
                $data = Product::where('store_id',auth()->user()->store_id)->get();
            else
                $data = null;

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex">';
                        $btn .= '<button class="btn btn-primary btn edit mr-2" data-id="'.$row['id'].'"  onclick="edit('.$row['id'].')"><i class="fa-solid fa-pencil"></i></button>';
                        $btn .= '<button class="btn btn-danger btn delete" data-id="'.$row['id'].'"  onclick="checkDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->addColumn('image', function($data) {
                        return '<img src="'.asset($data->image).'" width="60px"/>';
                    })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }

        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        $subcategories = SubCategory::where('store_id', auth()->user()->store_id)->get();
        return view('products.index', compact('categories','subcategories'));
    }

    public function create()
    {
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        $subcategories = SubCategory::where('store_id', auth()->user()->store_id)->get();
        return view('products.create', compact('categories','subcategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            $path = '/images/product';
            if ($request->hasFile('image')) {
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move(public_path().$path, $image_name);
                $image_path = $path.'/'.$image_name;
            }

            $product = Product::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image_path,
                'store_id' => auth()->user()->store_id,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'original_price' => $request->original_price,
                'discounted_price' => $request->discounted_price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'status' => $request->status,
                'subcategory_id' => $request->subcategory_id,
            ]);

            return response()->json(['status' => true, 'message' => 'Product created successfully']);
        } catch(\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json(['status' => true, 'data' => $product]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try{
            $product = Product::find($id);
            $path = '/images/product';
            if ($request->hasFile('image')) {
                $old_image = $product->image;
                if(file_exists($old_image)){
                    unlink($old_image);
                }
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move(public_path().$path, $image_name);
                $image_path = $path.'/'.$image_name;
            } else {
                $image_path = $product->image;
            }

            $product->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image_path,
                'store_id' => auth()->user()->store_id,
                'category_id' => $request->category_id,
                'price' => $request->price,
                'original_price' => $request->original_price,
                'discounted_price' => $request->discounted_price,
                'stock' => $request->stock,
                'sku' => $request->sku,
                'status' => $request->status,
                'subcategory_id' => $request->subcategory_id,
            ]);

            return response()->json(['status' => true, 'message' => 'Product updated successfully']);
        } catch(\Exception $e){
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $path = $product->image;
        if(file_exists($path)){
            unlink($path);
        }
        $product->delete();
        return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
    }

    public function details($id)
    {
        $product = Product::find($id);
        return view('products.details', compact('product'));
    }

    public function activate($id)
    {
        $product = Product::find($id);
        $product->status = 'active';
        $product->save();

        return response()->json(['status' => true, 'message' => 'Product activated successfully']);
    }
}
