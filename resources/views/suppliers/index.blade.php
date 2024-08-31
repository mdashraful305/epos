@extends('layouts.back')
@section('title', 'Manage Suppliers')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Suppliers</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Suppliers</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Suppliers List</h4>
                  <div class="card-header-form">
                    @can('create-supplier')
                        <a href="javascript:void(0)" class="btn btn-success btn-sm my-2" data-toggle="modal" data-target="#modelId"><i class="bi bi-plus-circle"></i>+Add New Supplier</a>
                    @endcan
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="data-table" class="table dataTable no-footer table-hover" style="width: 100%">
                      <thead>
                        <tr>
                            <th>S#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
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
   <!-- Modal -->
   <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('suppliers.store') }}" method="POST" id="supplier-add">
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

<script type="text/javascript">

    $(document).ready(function() {

        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            orderable: true,
            ajax: "{{ route('suppliers.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#modelId').on('hidden.bs.modal', function () {
            $('#supplier-add')[0].reset();
            $('#modelId').find('.modal-title').text('Create Supplier');
            $('#submit').text('Submit');
            $('#supplier-add').attr('action', '{{ route('suppliers.store') }}');
        });

        $("#supplier-add").on('submit', function(e){
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
                        table.draw();
                        $('#supplier-add')[0].reset();
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                    }
                },
                error: function(err){
                    console.log(err.responseJSON);
                    if (err.status === 422) {
                        var errors = err.responseJSON.errors;
                        // Display errors to the user
                        $.each(errors, function(key, value) {
                            iziToast.error({title: 'Error',timeout: 1500,message:value,position: 'topRight'});
                        });
                    }else{
                        iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                    }
                }
            });
        });

    });

    function checkDelete(id) {
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");
        var url = "{{ url('/') }}"+'/suppliers/destroy/'+id;
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
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data) {
                        if(data.status){
                            iziToast.success({title: 'Success',timeout: 1500,message: data.message,position: 'topRight'});
                            $('#data-table').DataTable().ajax.reload();
                        }else{
                            iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                        }
                    },
                    error: function(err){
                        iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
                    }
                });
            }
        });
    };

    function edit(id) {
        var id = id;
        var url = "{{ url('/') }}"+'/suppliers/edit/'+id;
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                if(data.status){
                    $('#modelId').modal('show');
                    $('#modelId').find('.modal-title').text('Update Supplier');
                    $('#supplier-add').attr('action', '{{ url('/') }}/suppliers/update/'+id);
                    $('#name').val(data.data.name);
                    $('#email').val(data.data.email);
                    $('#phone').val(data.data.phone);
                    $('#address').val(data.data.address);
                    $('#submit').text('Update');
                }else{
                    iziToast.error({title: 'Error',timeout: 1500,message: data.message,position: 'topRight'});
                }
            },
            error: function(err){
                console.log(err);
                iziToast.error({title: 'Error',timeout: 1500,message: 'Something went wrong. Please try again later',position: 'topRight'});
            }
        });
    }
</script>
@endpush
