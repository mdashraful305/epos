@extends('layouts.back')
@section('title', 'Manage Categories')
@push('styles')
<style>

    .section-products .single-product {
        margin-bottom: 26px;
    }

    .section-products .single-product .part-1 {
        position: relative;
        height: 150px;
        max-height: 150px;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .section-products .single-product .part-1::before {
            position: absolute;
            content: "";
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            transition: all 0.3s;
    }

    .section-products .single-product:hover .part-1::before {
            transform: scale(1.2,1.2) rotate(5deg);
    }
    .section-products .single-product .part-1 .discount,
    .section-products .single-product .part-1 .new {
        position: absolute;
        top: 15px;
        left: 20px;
        color: #ffffff;
        background-color: #fe302f;
        padding: 2px 8px;
        text-transform: uppercase;
        font-size: 0.85rem;
    }

    .section-products .single-product .part-1 .new {
        left: 0;
        background-color: #444444;
    }


    .section-products .single-product:hover .part-1 ul {
        bottom: 30px;
        opacity: 1;
    }

    .section-products .single-product .part-2 .product-title {
        font-size: 14px;
    }

    .section-products .single-product .part-2 h4 {
        display: inline-block;
        font-size: 14px;
    }

    .section-products .single-product .part-2 .product-old-price {
        position: relative;
        padding: 0 7px;
        margin-right: 2px;
        opacity: 0.6;
    }

    .section-products .single-product .part-2 .product-old-price::after {
        position: absolute;
        content: "";
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        background-color: #444444;
        transform: translateY(-50%);
    }
    .selected-product-column {
        width: 100%;
        margin-top: 20px;
        border-radius: 10px;
        font-family: 'Arial', sans-serif;
    }
    .product-cart{
        align-items: center;
    }

    .product-image {
        width: 70px;
        height: auto;
        border-radius: 8px;
    }

    .product-name {
        font-size: 14px;
        margin: 0px 0 5px;
        color: #343a40;
    }

    .product-price {
        font-size: 1.1em;
        color: #28a745;
        font-weight: bold;
    }

    .remove-btn {
        background-color: #dc3545;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .remove-btn:hover {
        background-color: #c82333;
    }
    .quantity-selector {
        border-radius: 5px;
        max-width: 100px;
    }

    .quantity-input {
        width: 50px;
        border: none;
        outline: none;
        font-size: 16px;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .cart-summary input[type="number"]{
        width: 100px;
        float: right;
        text-align: right;
        outline: none;
    }
    .cart-summary{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .cart-summary label{
        font-weight: bold;
        font-size: 16px;
    }
    .cart-summary div, .cart-summary input{
        font-weight: bold;
        font-size: 16px;
    }

</style >
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Pos</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Pos</div>
      </div>
    </div>


    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <img class="card-img-top" src="holder.js/100x180/" alt="">
                <div class="card-body">
                    <form class="">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Search By Product Name / SKU ">
                            </div>
                            <div class="col">
                                <div class="form-group">
                                  <select class="form-control" name="" id="">
                                    <option>All Categories</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control" name="" id="">
                                      <option>All Sub Categories</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </form>

                    <section class="section-products">
                        <div class="container">
                                <div class="row">
                                        <!-- Single Product -->
                                        @for ($i = 0; $i < 12; $i++)
                                            <div class="card col-md-2 col-lg-2 col-xl-2">
                                                <div id="product-1" class="single-product text-center">
                                                        <div class="part-1" style=" background: url(https://demo.activeitzone.com/ecommerce/uploads/all/B1hum7tEVbTF5SOV0eQdwB6NgyLUPO1wif5QtaO8.webp) center /contain no-repeat">
                                                        </div>
                                                        <div class="part-2">
                                                                <h3 class="product-title">Here Product Title</h3>
                                                                <h4 class="product-old-price">$79.99</h4>
                                                                <h4 class="product-price">$49.99</h4>
                                                        </div>

                                                        <button class="btn btn-outline-danger mt-1"><i class="fa-solid fa-cart-shopping"></i>Add to Cart</button>
                                                </div>
                                            </div>
                                        @endfor
                                </div>
                        </div>
                </section>
                </div>
            </div>
        </div>
        <div class="col-md-4 card cart-summary">

            <div class="">
                <img class="card-img-top" src="holder.js/100x180/" alt="">

                <div class="input-group">
                    <select class="custom-select" id="inputGroupSelect04">
                    <option value="1">Walk in Customer</option>
                    </select>
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button"><i class="fa-solid fa-user-plus"></i></button>
                    </div>
                </div>
                @for ($i = 0; $i < 2; $i++)
                    <div class="selected-product-column">
                            <div class="row product-cart">
                                <div class="col-md-2">
                                    <img src="https://demo.activeitzone.com/ecommerce/uploads/all/B1hum7tEVbTF5SOV0eQdwB6NgyLUPO1wif5QtaO8.webp" alt="Product Image" class="product-image ">
                                </div>
                                <div class="col-md-4">
                                    <h3 class="product-name">Product Name</h3>
                                    <p class="product-price">$19.99</p>
                                </div>
                                <div class="col-md-4">
                                    <div class="quantity-selector d-flex align-items-center justify-content-between">
                                        <i class="fa-solid fa-minus stepper-icon" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"></i>
                                        <input type="number" class="form-control text-center quantity-input px-1" value="1" min="1" max="10">
                                        <i class="fa-solid fa-plus stepper-icon" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"></i>
                                    </div>


                                </div>
                                <div class="col-md-2">
                                    <button class="remove-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @endfor
            </div>
            <div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Sub Total</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" id="sub-total" value="100" readonly>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" id="discount" value="0" placeholder="0">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Tax</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" id="tax" value="0" placeholder="0">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Shipping</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" id="shipping" value="0" placeholder="0">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Total</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" id="total" value="120" readonly>
                    </div>
                </div>
                <div class="text-center my-3">
                    <button class="btn btn-danger btn-lg" id="clear"><b>Clear</b></button>
                    <button class="btn btn-info btn-lg"><b>Hold</b></button>
                    <button class="btn btn-success btn-lg"><b>Place Order</b></button>

                </div>
            </div>



        </div>
    </div>


@endsection
@push('scripts')
    <script>
        function calculateTotal(){
            let subTotal = parseFloat($("#sub-total").val());
            let discount = parseFloat($("#discount").val());
            let tax = parseFloat($("#tax").val());
            let shipping = parseFloat($("#shipping").val());
            let total = subTotal - discount + tax + shipping;
            $("#total").val(total);
        }
        $("#discount").keyup(function (e) {
            calculateTotal();
        });
        $("#tax").keyup(function (e) {
            calculateTotal();
        });
        $("#shipping").keyup(function (e) {
            calculateTotal();
        });

        $("#clear").click(function (e) {
            $("#sub-total").val(0);
            $("#discount").val(0);
            $("#tax").val(0);
            $("#shipping").val(0);
            $("#total").val(0);

            $('.selected-product-column').html('');
        });
    </script>
@endpush
