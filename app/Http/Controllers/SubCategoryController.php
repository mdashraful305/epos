<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner')) {
                $data = SubCategory::with('category')->where('store_id', auth()->user()->store_id)->get();
            } else {
                $data = null;
            }

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<div class="d-flex">';
                        $btn .= '<button class="btn btn-primary btn edit mr-2" data-id="'.$row['id'].'" onclick="edit('.$row['id'].')"><i class="fa-solid fa-pencil"></i></button>';
                        $btn .= '<button class="btn btn-danger btn delete" data-id="'.$row['id'].'" onclick="checkDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->addColumn('image', function($data) {
                        return '<img src="'.asset($data->image).'" width="60px"/>';
                    })
                    ->addColumn('category_name', function($data) {
                        return $data->category ? $data->category->name : 'N/A';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
        }

        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        return view('subcategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('store_id',auth()->user()->store_id)->get();

        return view('subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store image
        try {
            $path = '/images/subcategory';
            if ($request->hasFile('image')) {
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move(public_path().$path, $image_name);
                $image_path = $path.'/'.$image_name;
            }

            //store subcategory
            $subcategory = SubCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image_path,
                'category_id' => $request->category_id,
                'store_id' => auth()->user()->store_id
            ]);

            return response()->json(['status' => true, 'message' => 'SubCategory created successfully']);
        } catch(\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        return response()->json(['status' => true, 'data' => $subcategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store image
        try {
            $subcategory = SubCategory::find($id);
            $path = '/images/subcategory';
            if ($request->hasFile('image')) {
                $old_image = $subcategory->image;
                if(file_exists(public_path().$old_image)){
                    unlink(public_path().$old_image);
                }
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move(public_path().$path, $image_name);
                $image_path = $path.'/'.$image_name;
            } else {
                $image_path = $subcategory->image;
            }

            //update subcategory
            $subcategory->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $image_path,
                'category_id' => $request->category_id,
                'store_id' => auth()->user()->store_id
            ]);

            return response()->json(['status' => true, 'message' => 'SubCategory updated successfully']);
        } catch(\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $path = $subcategory->image;
        if(file_exists(public_path().$path)){
            unlink(public_path().$path);
        }
        $subcategory->delete();
        return response()->json(['status' => true, 'message' => 'SubCategory deleted successfully']);
    }
}
