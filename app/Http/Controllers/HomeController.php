<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\WithExportQueue;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use WithExportQueue;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function profile()
    {
        return view('users.profile');
    }

    public function reportIndex(Request $request)
    {
        if($request->ajax()){
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $table_data=[];
            $data=Order::query();
            if($startDate!=null){
                $data=$data->whereDate('created_at','>=',$startDate);
            }
            if($endDate!=null){
                $data=$data->whereDate('created_at','<=',$endDate);
            }
            $data=$data->with('carts')
                    ->get();
            foreach($data as $item){
                $cart_items=[];
                $profit=0;
                foreach($item->carts as $cart){
                    $cart_items[]=[
                        'product_name'=>$cart->product->name,
                        'quantity'=>$cart->quantity,
                        'price'=>$cart->price,
                        'total_price'=>$cart->total
                    ];
                    $profit+=$cart->quantity*$cart->product->original_price;
                }
                $table_data[]=[
                    'order_id'=>$item->id,
                    'customer_name'=>$item->customer->name,
                    'store_name'=>$item->store->name,
                    'total_amount'=>$item->total_amount,
                    'payment_status'=>$item->payment_status,
                    'order_status'=>$item->order_status,
                    'shipping_address'=>$item->shipping_address,
                    'billing_address'=>$item->billing_address,
                    'cart_items'=>$cart_items,
                    'profit'=>$item->total_amount-$profit
               ];
            }

            return DataTables::of($table_data)
                ->addIndexColumn()

                 ->make(true);
       }


        return view('reports.index');
    }
}
