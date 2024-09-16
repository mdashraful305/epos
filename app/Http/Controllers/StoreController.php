<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner'))
                $data = Store::where('id',auth()->user()->store_id)->get();
            else
                $data = null;

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex">';
                        $btn .= '<a href="'.route('stores.edit',$row->id).'" class="btn btn-primary btn edit mr-2"><i class="fa-solid fa-pencil"></i></a>';
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

        return view('stores.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $store = Store::find($id);
        return view('stores.show',compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
       $store = Store::find($request->id);
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/stores');
            $image->move($destinationPath, $name);
            $image_path = 'images/stores/'.$name;
        }
        else{
            $image_path = $store->image;
        }
        $store->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'image' => $image_path,
            'description' => $request->description,
            'slug' => slug( $request->name),
        ]);
        return response()->json(['status' => true,'message' => 'Store Updated Successfully','store' => $store]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        //
    }
}
