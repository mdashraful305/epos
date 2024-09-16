<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Expense;
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

    public function reportIndex(Request $request){
         if($request->ajax()){
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $table_data=[];
            $data=Order::query();
            $expense=Expense::query();
            $data->where('store_id',auth()->user()->store_id);
            $expense->where('store_id',auth()->user()->store_id);
            if($startDate!=null){
                $data=$data->whereDate('created_at','>=',$startDate);
            }
            if($endDate!=null){
                $data=$data->whereDate('created_at','<=',$endDate);
            }
            $date[]=Order::select(DB::raw('DATE(created_at) as date'))
                ->where('store_id',auth()->user()->store_id)
                ->distinct()
                ->get('created_at');

            $date[]=Expense::select(DB::raw('DATE(created_at) as date'))
                ->where('store_id',auth()->user()->store_id)
                ->distinct()
                ->get('created_at');

            foreach ($date as $key=>$ditem) {
                $profit = 0;
                $orders = 0;
                $total=0;
                $ex=0;
                $others=0;
                $cr_date=$ditem[0]->date;

                $all_carts = Order::whereDate('created_at',  $cr_date)
                ->where('store_id', auth()->user()->store_id)
                ->with('carts')
                ->get();

                $expenses = Expense::whereDate('created_at',  $cr_date)
                ->where('store_id', auth()->user()->store_id)
                ->get();
                if(!empty($expenses)){
                    foreach ($expenses as $expense) {
                        $ex += $expense->expense_amount;
                    }
                }

                if(!empty($all_carts)){
                    foreach ($all_carts as $citem) {
                        foreach ($citem->carts as $item) {
                            $profit += $item->quantity * $item->product->original_price;
                            $orders++;
                        }
                        $total+=$citem->total_amount;
                        $others+=$citem->shipping_charge+$citem->tax;

                    }
                }
                $table_data[$key] = [
                    'date' => $cr_date??'',
                    'profit' => number_format(($total - $profit-$others)-$ex, 2),
                    'expense' => number_format($ex, 2),
                    'total_amount' => number_format($total, 2),
                    'total_orders' => $orders,
                ];

            }

            return DataTables::of($table_data)
                ->addIndexColumn()

                ->make(true);
            }
            return view('reports.index');
    }

    public function reportOrders(Request $request)
    {
        if($request->ajax()){
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $table_data=[];
            $data=Order::query();
            $data->where('store_id',auth()->user()->store_id);
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
                $sub_total=0;
                foreach($item->carts as $cart){
                    $cart_items[]=[
                        'product_name'=>$cart->product->name,
                        'quantity'=>$cart->quantity,
                        'price'=>$cart->price,
                        'total_price'=>$cart->total
                    ];
                    $sub_total+=$cart->total;
                    $profit+=$cart->quantity*$cart->product->original_price;
                }
                $table_data[]=[
                    'order_id'=>$item->id,
                    'customer_name'=>$item->customer->name,
                    'store_name'=>$item->store->name,
                    'total_amount'=>number_format($item->total_amount,2),
                    'payment_status'=>$item->payment_status,
                    'order_status'=>$item->order_status,
                    'shipping_address'=>$item->shipping_address,
                    'billing_address'=>$item->billing_address,
                    'cart_items'=>$cart_items,
                    'shipping_cost'=>number_format($item->shipping_charge ,2),
                    'tax'=>number_format($item->tax,2),
                    'discount'=>number_format($item->discount,2),
                    'sub_total'=>number_format($sub_total,2),
                    'profit'=>number_format(($item->total_amount-$profit-$item->shipping_charge-$item->tax),2),
               ];
            }

            return DataTables::of($table_data)
                ->addIndexColumn()

                 ->make(true);
       }


        return view('reports.orders');
    }

    public function reportCustomer(Request $request){
        if($request->ajax()){
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $table_data=[];
            $data=Customer::query();

            if($startDate!=null){
                $data=$data->whereDate('created_at','>=',$startDate);
            }
            if($endDate!=null){
                $data=$data->whereDate('created_at','<=',$endDate);
            }
            $data=$data->where('store_id',auth()->user()->store_id)
                ->with('orders')
                ->get();
              foreach($data as $item){
                     $total_amount=0;
                     $total_profit=0;
                     $total_orders=0;
                     foreach($item->orders as $order){
                         $total_amount+=$order->total_amount;
                         $profit=0;
                         foreach($order->carts as $cart){
                             $profit+=$cart->quantity*$cart->product->original_price;
                         }
                         $total_profit+=$order->total_amount-$profit;
                         $total_orders++;
                     }
                     $table_data[]=[
                         'customer_name'=>$item->name,
                         'total_amount'=>number_format($total_amount,2),
                         'total_profit'=>number_format($total_profit,2),
                         'total_orders'=>$total_orders
                     ];
                 }

            return DataTables::of($table_data)
                ->addIndexColumn()

                 ->make(true);
       }
       return view('reports.customers');
    }
}
