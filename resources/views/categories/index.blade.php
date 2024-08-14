@extends('layouts.back')
@section('title', 'Manage Categories')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Categories</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Categories</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Categories List</h4>
                  <div class="card-header-form">
                    @can('create-categorie')
                        <a href="javascript:void(0)" class="btn btn-success btn-sm my-2" data-toggle="modal" data-target="#modelId"><i class="bi bi-plus-circle"></i> Add New Category</a>
                    @endcan
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="data-table" class="table dataTable no-footer table-hover" style="width: 100%">
                      <thead>
                        <tr>
                          <tr>
                            <th >S#</th>
                            <th >Name</th>
                            <th >image</th>
                            <th >Action</th>
                          </tr>
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
                <h5 class="modal-title">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" id="cate-add">
            <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId" placeholder="Enter Title">
                      </div>
                      <div class="form-group">
                          <label for="">Image</label>
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" name="image" id="image" accept="image/*">
                              <label class="custom-file-label" for="image">Choose file</label>
                          </div>
                          <div class="image-preview mt-2" style="display: none">
                              <img src="" alt="" id="preview" width="100%">
                          </div>
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
            ajax: "{{ route('categories.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#image').on('change', function() {
            var file = this.files[0];
            $("#image").next('.custom-file-label').html(file.name);
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('.image-preview').show();
            }
            reader.readAsDataURL(file);
        });

        $("#cate-add").on('submit', function(e){
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
                        iziToast.success({
                            title: 'Success',
                            timeout: 2000,
                            message: data.message,
                            position: 'topRight'

                        });
                        $('#modelId').modal('hide');
                        table.draw();
                        $('#cate-add')[0].reset();
                    }else{
                        iziToast.error({
                            title: 'Error',
                            timeout: 2000,
                            message: data.message,
                            position: 'topRight'

                        });
                    }
                },
                error: function(err){
                    if (err.status === 422) {
                        var errors = err.responseJSON.errors;
                        // Display errors to the user
                        $.each(errors, function(key, value) {
                            iziToast.error({
                                title: 'Error',
                                timeout: 2000,
                                message: value,
                                position: 'topRight'

                            });
                        });
                    }else{
                        iziToast.error({
                            title: 'Error',
                            timeout: 2000,
                            message: 'Something went wrong. Please try again later',
                            position: 'topRight'

                        });
                    }
                }
            });
        });


    });
    function checkDelete(id) {

        var id =id;
        var token = $("meta[name='csrf-token']").attr("content");
        var url="{{ url('/') }}"+'/categories/destroy/'+id;
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
                            iziToast.success(data.message);
                            $('#data-table').DataTable().ajax.reload();
                        }else{
                            iziToast.error(data.message);
                        }
                    },
                    error: function(err){
                        iziToast.error('Something went wrong. Please try again later');
                    }
                });
            }
        });
       };
  </script>
@endpush
