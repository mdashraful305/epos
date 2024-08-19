@extends('layouts.back')
@section('title', 'Manage Products')
@push('scripts')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Products</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Products</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Products List</h4>
                  <div class="card-header-form">
                    @can('create-product')
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm my-2" ><i class="bi bi-plus-circle"></i> +Add New Category</a>
                    @endcan
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Image</th>
                          <th>Category</th>
                          <th>Price</th>
                          <th>Stock</th>
                          <th>Status</th>
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
@push('modals')

@endpush
@push('scripts')


<script type="text/javascript">



    $(document).ready(function() {
              var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            bAutoWidth:false,
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price', orderable: false, searchable: false},
                {data: 'stock', name: 'stock', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "fnDrawCallback": function() {
              $('.toggle-demo').bootstrapToggle();
            },

        });
    });

    function checkDelete(id) {
        var token = $("meta[name='csrf-token']").attr("content");
        var url = "{{ url('/') }}" + '/products/destroy/' + id;
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: {"_token": token},
                    success: function (data) {
                        if(data.status){
                            $('#data-table').DataTable().ajax.reload();
                        } else {
                            alert(data.message);
                        }
                    },
                    error: function(err){
                        alert('Something went wrong. Please try again later.');
                    }
                });
            }
        });
    }

    function status($id,value) {

        var status = value ;

        var id = $id;
        var token = $("meta[name='csrf-token']").attr("content");
        var url = "{{ url('/') }}" + '/products/change-status/';
        $.ajax({
            type: "POST",
            url: url,
            data: {"_token": token, "status": status, "id": id},
            success: function (data) {
                if(data.status){
                    iziToast.success({title: 'Success',timeout: 1500,message: data.message,position: 'topRight'});
                    $('#data-table').DataTable().ajax.reload();
                } else {
                    iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                }
            },
            error: function(err){
                iziToast.error({title: 'Error',timeout: 1500,message: 'Something Went Wrong',position: 'topRight'});
            }
        });
    };
</script>
@endpush
