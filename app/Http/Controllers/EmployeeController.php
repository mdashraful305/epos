<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(auth()->user()->hasRole('Shop Owner')){
                    $data = User::where('store_id', auth()->user()->store_id)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'Employee');
                        })
                        ->get();
                }
            else
                $data = null;

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('roles', function($row){
                        return $row->getRoleNames()->implode(', ');
                    })
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

        return view('employees.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //store customer
        try {
            $employee = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'store_id' => auth()->user()->store_id
            ]);
            $employee->syncRoles('Employee');

            return response()->json(['status' => true, 'message' => 'Employee created successfully', 'data' => $employee]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = User::find($id);
        return response()->json(['status' => true, 'data' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'email' => 'required|string|email:rfc,dns|max:250|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        //update customer
        try {
            $employee = User::find($id);
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => ($request->password) ? Hash::make($request->password) : $employee->password,
                'store_id' => auth()->user()->store_id
            ]);
            return response()->json(['status' => true, 'message' => 'Employee updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = User::find($id);
        $employee->delete();
        return response()->json(['status' => true, 'message' => 'Employee deleted successfully']);
    }
}
