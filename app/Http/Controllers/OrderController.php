<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
                $data = Order::where('store_id', auth()->user()->store_id)->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('customer', function($row){
                            return $row->customer->name;
                        })
                        ->addColumn('mobile', function($row){
                            return $row->customer->phone;
                        })
                        ->addColumn('qty', function($row){
                            return $row->carts->count();
                        })
                        ->addColumn('Products', function($row){
                            $products = '';
                            foreach($row->carts as $cart){
                                $products .= $cart->product->name.', ';
                            }
                            return $products;
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
        return view('orders.index');
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
        DB::beginTransaction();
        try{
            $order=Order::create([
                'customer_id'=>$request->customer_id,
                'store_id'=>auth()->user()->store_id,
                'discount'=>$request->discount,
                'tax'=>$request->tax,
                'shipping_charge'=>$request->shipping_charge,
                'total_amount'=>$request->total_amount,
            ]);

            $cartItems = Cart::where('store_id', auth()->user()->store_id)
                        ->where('customer_id', $request->customer_id)
                        ->where('status', 'pending')
                        ->pluck('id')->toArray();

            $order->carts()->attach($cartItems);
            Cart::whereIn('id', $cartItems)->update(['status' => 'ordered']);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => true, 'message' => 'Order created successfully']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
