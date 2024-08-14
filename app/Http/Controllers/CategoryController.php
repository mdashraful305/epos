<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                        $btn = '<div class="d-flex">';
                        $btn .= '<a href="'.route("categories.edit",$row['id']).'" class="btn btn-primary btn-sm mr-2"><i class="bi bi-pencil-square"></i> Edit</a>';
                        $btn .= '<form action="'.route("categories.destroy",$row['id']).'" method="POST">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm mr-2"><i class="bi bi-trash"></i> Delete</button>
                        </form>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->addColumn('image', function($data) {
                        return '<img src="'.asset('public/storage/category/'.$data->image).'" width="70px"/>';
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
