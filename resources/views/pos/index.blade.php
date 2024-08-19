@extends('layouts.back')
@section('title', 'Manage Categories')
@push('styles')
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
                                    <select class="form-control" name="category_id" id="category_id">
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
                @can('create-customer')
                <div class="input-group">
                    <select class="custom-select" id="inputGroupSelect04">
                        <option value="1">Walk in Customer</option>
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#modelId"><i class="fa-solid fa-user-plus"></i></button>
                    </div>
                </div>
            @endcan
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



        $(document).ready(function() {
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
                        $('#data-table').DataTable().ajax.reload();
                        $('#customer-add')[0].reset();
                        modalShown = true; // Prevent modal from showing again
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                    }
                },
                error: function(err){
                    console.log(err.responseJSON);
                    if (err.status === 422) {
                        // Handle validation errors
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                    }
                }
            });
        });
    });


    $(document).ready(function() {
        $('#category_id').change(function() {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    url: "{{ route('products.subcategories') }}",
                    type: "POST",
                    data: {
                        category_id: category_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
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
                $("#subcategory_id").prop('disabled', true);
                $("#subcategory_id").html('<option value="">Select Category First</option>');
            }
        });
    });


    </script>
@endpush
