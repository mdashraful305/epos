<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class PosController extends Controller
{

    public function index()
    {
        $categories = Category::where('store_id', auth()->user()->store_id)->get();
        return view('pos.index', compact('categories'));
    }

    public function getSubCategories(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['status' => true, 'data' => $subcategories]);
    }

    public function getProducts(Request $request)
    {
       $product=Product::query();
        $product->where('store_id', auth()->user()->store_id)->where('status', 1);
         if($request->category_id!=null){
              $product->where('category_id',$request->category_id);
         }
        if($request->subcategory_id!=null){
            $product->where('subcategory_id',$request->subcategory_id);
        }
        if($request->search!=null){
            $product->where('name','LIKE',"%{$request->search}%");
        }

        $perPage = 12;
        $currentPage = $request->input('page', 1);

        $products = $product->paginate($perPage, ['*'], 'page', $currentPage);


        return response()->json([
            'status' => true,
            'data' => $products->items(),
            'next_page' => $products->hasMorePages() ? $currentPage + 1 : null,
        ]);

    }

    public function getCustomers(Request $request)
    {
        $search = $request->input('search');
        $data = Customer::select('id','name')
                ->where('store_id', auth()->user()->store_id)
                ->where('name','LIKE',"%{$search}%")
                ->orWhere('phone','LIKE',"%{$search}%")
                ->get();

        $results = $data->map(function($item) {
            return [
                'id' => $item->id,
                'text' => $item->name
            ];
        });

        return response()->json(['status' => true, 'results' => $results]);
  }
  public function cartDetails($customer_id){
        $cart=Cart::where('customer_id',$customer_id)->where('status','pending')->get();
        $html='';
        foreach($cart as $item){
            $html .= '<div class="row product-cart" id="product-'.$item->id.'">';
            $html .= ' <div class="col-md-2"><img src="'.$item->product->image.'" alt="Product Image" class="product-image "></div>';
            $html .= ' <div class="col-md-4">';
            $html .= ' <h3 class="product-name">'.$item->product->name.'</h3>';
            $html .= ' <p class="product-price">$'.$item->price.'</p>';
            $html .= ' </div>';
            $html .= ' <div class="col-md-4">';
            $html .= ' <div class="quantity-selector d-flex align-items-center justify-content-between"><i
                        class="fa-solid fa-minus stepper-icon"
                        onclick="this.parentNode.querySelector(\'input[type=number]\').stepDown()"></i>';
            $html .= ' <input type="number" class="form-control text-center quantity-input px-1" value="'.$item->quantity.'" min="1" max="10">
                        <i class="fa-solid fa-plus stepper-icon" onclick="this.parentNode.querySelector(\'input[type=number]\').stepUp()"></i></div>';
            $html .= ' </div>';
            $html .= '<div class="col-md-2"><button class="remove-btn" onclick="removeFromCart('.$item->id.')"><i
                        class="fas fa-trash"></i></button></div></div>';
        }
    return $html;
  }
  public function loadCart(Request $request){
        $html=$this->cartDetails($request->customer_id);
        $subtotal=Cart::CartSubTotal($request->customer_id);
        return response()->json(['status' => true, 'data' => $html,'subtotal'=>$subtotal]);
  }
  public function addToCart(Request $request){
        $product = Product::find($request->product_id);
        if($request->customer_id==null){
            return response()->json(['status' => false,'message'=>'Please Select Customer']);
        }
        $data=[
            'product_id'=>$product->id,
            'quantity'=>$request->quantity,
            'price'=>$product->discounted_price,
            'total'=>$product->discounted_price*$request->quantity,
            'added_by'=>auth()->id(),
            'customer_id'=>$request->customer_id,
            'store_id'=>auth()->user()->store_id,
            'status'=>'pending',
        ];
        $cart=Cart::create($data);
        $html=$this->cartDetails($request->customer_id);

        $subtotal=Cart::CartSubTotal($request->customer_id);


        return response()->json(['status' => true,'message'=>'Product Added Successflly', 'data' => $html,'subtotal'=>$subtotal]);
  }

  public function removeCartItem(Request $request){
        $cart=Cart::find($request->product_id);
        $cart->delete();
        $html=$this->cartDetails($cart->customer_id);
        $subtotal=Cart::CartSubTotal($cart->customer_id);
        return response()->json(['status' => true,'message'=>'Product Removed Successflly', 'data' => $html,'subtotal'=>$subtotal]);
  }
}
