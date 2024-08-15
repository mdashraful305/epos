<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner'))
                $data = Customer::where('store_id',auth()->user()->store_id)->get();
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
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store customer
        try {
            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'slug' => Str::slug($request->name),
                'store_id' => auth()->user()->store_id
            ]);

            return response()->json(['status' => true, 'message' => 'Customer created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json(['status' => true, 'data' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //update customer
        try {
            $customer = Customer::find($id);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'slug' => Str::slug($request->name),
                'store_id' => auth()->user()->store_id
            ]);

            return response()->json(['status' => true, 'message' => 'Customer updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json(['status' => true, 'message' => 'Customer deleted successfully']);
    }
}
