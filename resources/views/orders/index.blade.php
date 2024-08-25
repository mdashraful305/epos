@extends('layouts.back')
@section('title', 'Manage Orders')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Orders</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Orders</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Orders List</h4>
                  <div class="card-header-form">
                    @can('create-product')
                    <a href="{{ route('pos.index') }}" class="btn btn-success btn-sm my-2" ><i class="bi bi-plus-circle"></i> +Add New Category</a>
                    @endcan
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Product Name</th>
                          <th>Customer Name</th>
                          <th>Mobile</th>
                          <th>Qty</th>
                          <th>Total</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
  </section>

@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
              var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            bAutoWidth:false,
            ajax: "{{ route('orders.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'Products', name: 'Products'},
                {data: 'customer', name: 'customer'},
                {data: 'mobile', name: 'mobile'},
                {data: 'qty', name: 'qty'},
                {data: 'total_amount', name: 'total_amount', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "fnDrawCallback": function() {
              $('.toggle-demo').bootstrapToggle();
            },

        });
    });

</script>
@endpush