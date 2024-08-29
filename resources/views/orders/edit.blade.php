@extends('layouts.back')
@section('title', 'Edit Order')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Edit Order</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Order</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Order Edit</h4>
                  <div class="card-header-form">
                    <div class="card-header-form">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">

                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Order Info</h4>
                      <div class="card-header-form">
                        <div class="card-header-form">
                            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="order_data">

                            </tbody>
                            <tfoot class="bg-secondary">
                                <tr>
                                    <td colspan="5" class="text-end"><strong>Total</strong></td>
                                    <td colspan="2" id="total">0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                      <h4>Customer info</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-6" >
                                {{ $order->customer->name }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Email :</strong></label>
                            <div class="col-md-6" >
                                {{ $order->customer->email }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone :</strong></label>
                            <div class="col-md-6" >
                                {{ $order->customer->phone }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Address:</strong></label>
                            <div class="col-md-6" >
                                {{ $order->customer->address }}
                            </div>
                        </div>



                    </div>
                </div>
            </div>
          </div>
    </div>
  </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            loadOrderData();
        });
        function loadOrderData(){
            $.ajax({
                type: "POST",
                url: "{{ action('App\Http\Controllers\OrderController@getOrderData') }}",
                data: {
                    order_id: "{{ $order->id }}",
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        $('#order_data').html(response.data);
                        $('#total').html(response.total);
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: response.message,position: 'topRight'});
                    }
                },
            });
        }
        function removeFromCart(id){
            $.ajax({
                type: "POST",
                url: "{{ route('pos.remove-cart-item') }}",
                data: {
                    cart_id: id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        iziToast.success({title: 'Success',timeout: 1500,message: response.message,position: 'topRight'});
                        loadOrderData();

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
    </script>
@endpush
