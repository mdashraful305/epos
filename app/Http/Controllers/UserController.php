<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       if($request->ajax()){
            $data = User::all()->except(auth()->user()->id);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function($row){
                    return $row->getRoleNames()->implode(', ');
                })
                ->addColumn('action', function($row){
                    $btn = '<div class="d-flex">';
                    $btn .= '<a href="'.route('users.show', $row->id).'" class="btn btn-info btn-sm mr-2"><i class="fa-solid fa-eye"></i></a>';
                    $btn .= '<a href="'.route('users.edit', $row->id).'" class="btn btn-primary btn-sm mr-2"><i class="fa-solid fa-pencil"></i></a>';
                    $btn .= '<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" onclick="checkDelete('.$row->id.')"><i class="fa-solid fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title=auth()->user()->hasRole('Shop Owner') ? 'Employee' : 'User';
        return view('users.index', compact('title'));

       }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        $roles = Role::pluck('name')->all();

        return view('users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['store_id'] = auth()->user()->store_id;
        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('User is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $roles = Role::pluck('name')->all();


        return view('users.edit', [
            'user' => $user,
            'roles' =>$roles ,
            'userRoles' => $user->roles->pluck('name')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }else{
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);


        return redirect()->route('users.index')
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // About if user is Super Admin or User ID belongs to Auth User
        $user = User::find($id);
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }
        $user->syncRoles([]);
        $user->delete();

        return response()->json(['status' => true, 'message' => 'User deleted successfully']);
    }
}
