<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = auth()->user()->hasRole('Shop Owner') ? Expense::where('store_id', auth()->user()->store_id)->get() : null;

            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<div class="d-flex">';
                        $btn .= '<button class="btn btn-primary btn edit mr-2" data-id="'.$row['id'].'" onclick="edit('.$row['id'].')"><i class="fa-solid fa-pencil"></i></button>';
                        $btn .= '<button class="btn btn-danger btn delete" data-id="'.$row['id'].'" onclick="checkDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></button>';
                        $btn .= '</div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // $categories = [
        //     "Rent", "Utilities", "Cleaning Services", "Salaries and Wages", "Employee Benefits",
        //     "Training and Development", "Travel and Accommodation", "Employee Reimbursements",
        //     "Advertising", "Promotions", "Public Relations", "Digital Marketing", "Software Licenses",
        //     "IT Support", "Website Maintenance", "Hardware Purchases", "Bank Fees", "Legal Fees",
        //     "Accounting and Auditing", "Taxes", "Insurance", "Raw Materials", "Finished Goods",
        //     "Freight and Shipping", "Packaging", "Depreciation", "Leasing", "Transportation",
        //     "Security", "Subscriptions", "Donations and Sponsorships", "Gifts and Entertainment",
        //     "Miscellaneous"
        // ];

        return view('expenses.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expense_date' => 'required|date',
            'expense_category' => 'required',
            'expense_description' => 'required',
            'expense_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            Expense::create([
                'expense_date' => $request->expense_date,
                'expense_category' => $request->expense_category,
                'expense_description' => $request->expense_description,
                'expense_amount' => $request->expense_amount,
                'store_id' => auth()->user()->store_id,
                'slug'=>slug($request->name)
            ]);

            return response()->json(['status' => true, 'message' => 'Expense created successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $expense = Expense::find($id);

        return response()->json([
            'status' => true,
            'data' => $expense
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'expense_date' => 'required|date',
            'expense_category' => 'required',
            'expense_description' => 'required',
            'expense_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $expense = Expense::find($id);
            $expense->update([
                'expense_date' => $request->expense_date,
                'expense_category' => $request->expense_category,
                'expense_description' => $request->expense_description,
                'expense_amount' => $request->expense_amount,
                'store_id' => auth()->user()->store_id,
                'slug'=>slug($request->name),
            ]);

            return response()->json(['status' => true, 'message' => 'Expense updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return response()->json(['status' => true, 'message' => 'Expense deleted successfully']);
    }
}
