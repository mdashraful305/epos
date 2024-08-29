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
                            $btn .= '<a href="'.route('orders.edit',$row['id']).'" class="btn btn-primary btn edit mr-2 text-white"><i class="fa-solid fa-pencil"></i></a>';
                            $btn .= '<button class="btn btn-danger btn delete mr-2" data-id="'.$row['id'].'"  onclick="checkDelete('.$row['id'].')"><i class="fa-solid fa-trash"></i></button>';
                            $btn.='<button class="btn btn-info btn" onclick="printReceipt('.$row['id'].')"><i class="fa-solid fa-print"></i></button>';
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
            $receiptView = view('pos.receipt',compact('order'))->render();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
        return response()->json(['status' => true, 'message' => 'Order created successfully', 'receipt' => $receiptView]);

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
    public function edit(Order $order,$id)
    {
        $order = Order::find($id);
        return view('orders.edit',compact('order'));
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
    public function destroy(Order $order,$id)
    {
        $order = Order::find($id);
        $order->delete();
        return response()->json(['status' => true, 'message' => 'Order deleted successfully']);
    }

    public function getOrderData(Request $request){
        $html='';
        $i=1;
        $total=0;
        $order=Order::find($request->order_id);
        foreach($order->carts as $item){
            $html.=' <tr>';
            $html.='    <td>'. $i++ .'</td>';
            $html.='    <td>';
            $html.='        <img src="'. asset($item->product->image) .'" alt="'. $item->product->name .'" width="50">';
            $html.='    </td>';
            $html.='    <td>'. $item->product->name .'</td>';
            $html.='     <td>'. $item->quantity .'</td>';
            $html.='     <td>'. number_format($item->price,2) .'</td>';
            $html.='     <td>'. number_format($item->total,2) .'</td>';
            $html.='     <td>';
            $html.=($order->carts->count()>1)?'<button class="btn btn-danger btn-sm" onclick="removeFromCart('. $item->id .')"><i class="fas fa-trash"></i></button>':'';
            $html.='     </td>';
            $html.=' </tr>';
            $total+=$item->total;
        }

        return response()->json(['status' => true, 'data' => $html, 'total' => number_format($total,2)]);
    }

    public function receipt(Request $request){
        $order = Order::find($request->id);
        $receiptView = view('pos.receipt',compact('order'))->render();
        return response()->json(['status' => true, 'receipt' => $receiptView]);
    }
}
