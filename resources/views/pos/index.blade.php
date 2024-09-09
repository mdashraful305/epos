@extends('layouts.back')
@section('title', 'Manage Pos')
@push('styles')
<style>
    .product-wrapper{
        position: relative
    }
    .ajax-loader {
        display: none;
        z-index: 30001;
    }
    .ajax-load-img{
        position: absolute;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }
</style>
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

    <div class="row" >
        <div class="col-md-8">
            <div class="card">
                <img class="card-img-top" src="holder.js/100x180/" alt="">
                <div class="card-body">

                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" id="category_search" placeholder="Search By Product Name / SKU ">
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control select2" name="category_id" id="category_id">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <select class="form-control select2" name="subcategory_id" id="subcategory_id" disabled>
                                        <option value="">Select Category First</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                    <section class="section-products">
                        <div class="container product-wrapper">
                                <div class="row">
                                        <!-- Single Product -->

                                </div>
                                <div class="ajax-loader">
                                    <img src="{{ url('https://upload.wikimedia.org/wikipedia/commons/c/c7/Loading_2.gif') }}" class="img-responsive ajax-load-img" />
                                </div>
                                <button class="btn btn-sm btn-primary float-right m-auto" id="load-more">Load More</button>
                        </div>
                </section>
                </div>
            </div>
        </div>
        <div class="col-md-4 card cart-summary">

            <div class="pt-3">
                @can('create-customer')
                <div class="mb-1 row">
                    <div class="col-sm-10">
                        <select class="custom-select" id="customer_select">
                        </select>
                    </div>
                    <div class="col-sm-2 text-right">
                        <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#modelId"><i class="fa-solid fa-user-plus"></i>Add</button>
                    </div>
                </div>

            @endcan
            <div class="selected-product-column">
                <div class="row product-cart">


                </div>
            </div>
            </div>
        <form class="" action="{{ route('orders.store') }}" method="POST" id="order-form">

            <div class="mt-5">
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Sub Total</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" name="sub-total" id="sub-total" value="0" readonly>
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Discount</label>
                    <div class="col-sm-9 text-right">
                        <input type="text" class="form-control text-right" name="discount" id="discount" value="0" placeholder="0 " data-toggle="tooltip" data-placement="top" title="Enter Percentage (0.5% or Any ) or Any Value (2,5,10)">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Tax</label>
                    <div class="col-sm-9 text-right">
                        <input type="text" class="form-control text-right" name="tax" id="tax" value="0" placeholder="0" data-toggle="tooltip" data-placement="top" title="Enter Percentage (0.5% or Any ) or Any Value (2,5,10)">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Shipping</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" name="shipping_charge" id="shipping" value="0" placeholder="0">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-sm-3 col-form-label">Total</label>
                    <div class="col-sm-9 text-right">
                        <input type="number" class="form-control" name="total_amount" id="total" value="0" readonly>
                    </div>
                </div>
                <div class="text-center my-3">
                    <button class="btn btn-danger btn-lg" id="clear"><b>Clear</b></button>
                    <button class="btn btn-info btn-lg"><b>Hold</b></button>
                    <button type="submit" class="btn btn-success btn-lg"><b>Place Order</b></button>

                </div>
            </div>
        </form>


        </div>
    </div>


@endsection
@push('modals')
   <!-- Modal -->
   <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('customers.store') }}" method="POST" id="customer-add">
            <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>


@endpush

@push('scripts')
    <script>
        function calculateTotal(){
            let subTotal = parseFloat($("#sub-total").val());
            let discount = $("#discount").val();
            if(discount.includes('%')){
                discount = parseFloat(discount.replace('%',''));
                discount = (subTotal * discount) / 100;
            }else{
                discount = parseFloat(discount);
            }
            let tax = $("#tax").val();
            if(tax.includes('%')){
                tax = parseFloat(tax.replace('%',''));
                tax = (subTotal * tax) / 100;
            }else{
                tax = parseFloat(tax);
            }

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
        function clear(){
            $("#sub-total").val(0);
            $("#discount").val(0);
            $("#tax").val(0);
            $("#shipping").val(0);
            $("#total").val(0);

            $('.selected-product-column').html('');
        }

        $("#clear").click(function (e) {
            clear();
        });



        $(document).ready(function() {
            clear();
        var clickCounter = 0;
        var maxClicks = 3; // Number of clicks to show the modal
        var modalShown = false;

        $('#customer-button').on('click', function() {
            if (!modalShown) {
                clickCounter++;
                if (clickCounter >= maxClicks) {
                    $('#modelId').modal('show');
                    clickCounter = 0; // Reset counter after showing the modal
                }
            }
        });

        $('#modelId').on('hidden.bs.modal', function () {
            $('#customer-add')[0].reset();
            $('#modelId').find('.modal-title').text('Create Customer');
            $('#submit').text('Submit');
            $('#customer-add').attr('action', '{{ route('customers.store') }}');
        });

        $("#customer-add").on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
               url: $(this).attr('action'),
               method: $(this).attr('method'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.status){
                        iziToast.success({title: 'Success',timeout: 1500,message: data.message,position: 'topRight'});
                        $('#modelId').modal('hide');
                        $('#customer-add')[0].reset();
                        $('#customer_select').append('<option value="'+data.data.id+'" selected>'+data.data.name+'</option>');
                        modalShown = true; // Prevent modal from showing again
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                    }
                },
                error: function(err){
                    if (err.status === 422) {
                        // Handle validation errors
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                    }
                }
            });
        });
    });
    $(document).ready(function () {
            var $select2 = $('#customer_select');

            $select2.select2({
            ajax: {
                url: '{{ route('pos.customers') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.results
                    };
                },
                cache: true
            },
            placeholder: 'Select an option',
            minimumInputLength: 1,
        });

        $select2.on('select2:open', function () {
            var searchField = $('.select2-search__field');

        });

        $select2.on('select2:select', function (e) {
            var data = e.params.data;
            clear();
            loadCart(data.id);
        });
    });
    let page = 1;
    function loadProducts(cat_id=null,sub_cat_id=null,search=null){
        $.ajax({
            type: "POST",
            url: "{{ route('pos.products') }}",
            data: {
                page: page,
                search: search,
                category_id: cat_id,
                subcategory_id: sub_cat_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            beforeSend: function() {
                $(".ajax-loader").show();
                $('#load-more').hide();
            },
            success: function (response) {
                if (response.status) {
                    $('.section-products .row').html('');
                    response.data.forEach(element  => {
                        $(".section-products .row").append('<div class="card col-md-2 col-lg-2 col-xl-2"><div id="product-1" class="single-product text-center"><div class="part-1" style=" background: url('+element.image+') center /contain no-repeat"></div><div class="part-2"><h3 class="product-title">'+element.name+'</h3><h4 class="product-old-price">$'+element.price+'</h4><h4 class="product-price">$'+element.discounted_price+'</h4></div><button class="btn btn-outline-danger mt-1" onclick=addToCart('+element.id+','+element.discounted_price+')><i class="fa-solid fa-cart-shopping"></i>Add to Cart</button></div></div>');

                    });
                    page++;
                    if(response.next_page==null){
                        $('#load-more').hide();
                        page=1;
                    }
                    else
                       $('#load-more').show();
                    $(".ajax-loader").hide();
                }else{
                    $('#load-more').hide();
                }
            },
            complete: function() {
                $(".ajax-loader").hide();
            },

        });
    }
    loadProducts();
    $('#category_search').on('keyup', function() {
        page=1;
        var value = $(this).val().toLowerCase();
        var cat_id=$('#category_id').val()??null;
        var sub_cat_id=$('#subcategory_id').val()??null;
        if(value.length>0){
            loadProducts(cat_id,sub_cat_id,value);
        }else{
            loadProducts(cat_id,sub_cat_id,null);
        }
    });
    $('#load-more').on('click', function() {
        $('#load-more').hide();
        $('.section-products .row').html('');
        loadProducts();
    });

    $(document).ready(function() {
        $('#category_id').change(function() {
            var category_id = $(this).val();
            var value=$('#category_search').val()??null;
            if (category_id) {
                loadProducts(category_id,null,value);
                $.ajax({
                    url: "{{ route('products.subcategories') }}",
                    type: "POST",
                    data: {
                        category_id: category_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response,) {
                        if (response.status) {
                            if (response.data.length > 0) {
                                $("#subcategory_id").prop('disabled', false);
                                $("#subcategory_id").html('<option value="">Select Subcategory</option>');
                                response.data.forEach(element => {
                                    $("#subcategory_id").append('<option value="' + element.id + '">' + element.name + '</option>');
                                });
                            } else {
                                $("#subcategory_id").prop('disabled', true);
                                $("#subcategory_id").html('<option value="null">No Subcategory Found</option>');
                            }
                        } else {
                            $("#subcategory_id").prop('disabled', true);
                            $("#subcategory_id").html('<option value="">Select Category First</option>');
                        }
                    }
                });
            } else {
                loadProducts(null,null,null);
                $("#subcategory_id").prop('disabled', true);
                $("#subcategory_id").html('<option value="">Select Category First</option>');
            }
        });
    });

    $('#subcategory_id').change(function (e) {
        e.preventDefault();
        var subcategory_id = $(this).val();
        loadProducts($('#category_id').val(),subcategory_id,null);
    });
    function loadCart(id){
        $.ajax({
            type: "GET",
            url: "{{ route('pos.load-cart') }}",
            data:{
                customer_id:id,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                if (response.status) {

                    $('.selected-product-column').html(response.data);
                    $("#sub-total").val(response.subtotal);
                   calculateTotal();
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: response.message,position: 'topRight'});
                }
            },
            error: function(err){
                if (err.status === 422) {
                    // Handle validation errors
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                }
            }
        });
    }

    // Add to cart
    function addToCart(id,price){
        var customer_id = $('#customer_select').val();
        $.ajax({
            type: "POST",
            url: "{{ route('pos.add-to-cart') }}",
            data: {
                product_id: id??null,
                price: price??null,
                customer_id: customer_id??null,
                quantity:1,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    iziToast.success({title: 'Success',timeout: 1500,message: response.message,position: 'topRight'});
                    $('.selected-product-column').html(response.data);
                    $("#sub-total").val(response.subtotal);
                    calculateTotal();

                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: response.message,position: 'topRight'});
                }
            },
            error: function(err){
                if (err.status === 422) {
                    // Handle validation errors
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                }
            }
        });
    }

    function removeFromCart(id){
        $.ajax({
            type: "POST",
            url: "{{ route('pos.remove-cart-item') }}",
            data: {
                product_id: id??null,
                _token: "{{ csrf_token() }}",
            },
            dataType: "json",
            success: function (response) {
                if (response.status) {
                    iziToast.success({title: 'Success',timeout: 1500,message: response.message,position: 'topRight'});
                    $('.selected-product-column').html(response.data);
                    $("#sub-total").val(response.subtotal);
                    calculateTotal();
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: response.message,position: 'topRight'});
                }
            },
            error: function(err){
                if (err.status === 422) {
                    // Handle validation errors
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                }
            }
        });
    }


    $(document).ready(function () {
        $('#order-form').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var customer_id = $('#customer_select').val();
            formData.append('customer_id', customer_id);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.status){
                        iziToast.success({title: 'Success',timeout: 1500,message: data.message,position: 'topRight'});
                        clear();
                        $('#customer_select').val(null).trigger('change');
                        printDiv(data.receipt);
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                    }
                },
                error: function(err){
                    if (err.status === 422) {
                        // Handle validation errors
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                    }
                }
            });
        });
    });
    </script>
@endpush
