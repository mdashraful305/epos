<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
