@extends('layouts.back')
@section('title') Manage User@endsection
@section('content')

<section class="section">
    <div class="section-header">
      <h1>Manage User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">User</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4></h4>
              <div class="card-header-form">
                @can('create-user')
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
                @endcan
              </div>
            </div>
            <div class="card-body ">
              <div class="table-responsive">
                <table id="data-table" class="table dataTable no-footer table-hover" style="width: 100%">
                    <thead>
                      <tr>
                            <th>S#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
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
            ajax: "{{ action('App\Http\Controllers\UserController@index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'roles', name: 'role'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

    function checkDelete(id) {
        var id =id;
        var token = $("meta[name='csrf-token']").attr("content");
        var url="{{ url('/') }}"+'/users/destroy/'+id;
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

</script>
@endpush
