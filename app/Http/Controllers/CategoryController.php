<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner'))
                $data = Category::where('store_id',auth()->user()->store_id)->get();
            else
                $data=null;

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
                        return '<img src="'.asset('images/category/'.$data->image).'" width="60px"/>';
                     })
                    ->rawColumns(['action','image'])
                    ->make(true);
        }

        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

            //validate request
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store image
        try{
            $path = public_path().'/images/category';
            if ($request->hasFile('image')) {
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move($path, $image_name);
                $image_path = $path.'/'.$image_name;
            }
        //store category
        $category=Category::create([
            'name'=>$request->name,
            'slug'=>slug($request->name),
            'image'=>$image_path,
            'store_id'=>auth()->user()->store_id
        ]);

            return response()->json(['status'=>true,'message'=>'Category created successfully']);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category=Category::find($id);
        return response()->json(['status'=>true,'data'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validate request
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'image'=>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store image
        try{
            $category=Category::find($id);
            $path = public_path().'/images/category';
            if ($request->hasFile('image')) {
                $old_image = $category->image;
                if(file_exists($old_image)){
                    unlink($old_image);
                }
                $image_name = auth()->user()->store_id.time() . '.' . $request->image->extension();
                $request->image->move($path, $image_name);
                $image_path = $path.'/'.$image_name;
            }else{
                $image_path=$category->image;
            }
        //store category
        $category->update([
            'name'=>$request->name,
            'slug'=>slug($request->name),
            'image'=>$image_path,
            'store_id'=>auth()->user()->store_id
        ]);

            return response()->json(['status'=>true,'message'=>'Category updated successfully']);
        }catch(\Exception $e){
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category=Category::find($id);
        $path = $category->image;
        if(file_exists($path)){
            unlink($path);
        }
        $category->delete();
        return response()->json(['status'=>true,'message'=>'Category deleted successfully']);
    }
}
