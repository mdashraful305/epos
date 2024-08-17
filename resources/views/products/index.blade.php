@extends('layouts.back')
@section('title', 'Manage Products')
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
                    <a href="javascript:void(0)" class="btn btn-success btn-sm my-2" data-toggle="modal" data-target="#modelId"><i class="bi bi-plus-circle"></i> +Add New Category</a>
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
                          <th>SKU</th>
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
                <h5 class="modal-title">Create Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" id="product-add" enctype="multipart/form-data">
            <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <img id="preview" src="#" alt="Image Preview" style="display:none; width: 100px; height: 100px;"/>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach($subcategories as $subcategorie)
                                <option value="{{ $subcategorie->id }}">{{ $subcategorie->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="price" placeholder="Enter Price">
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="text" class="form-control" name="stock" id="stock" placeholder="Enter Stock">
                    </div>
                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter SKU">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
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
            ajax: "{{ route('products.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'image', name: 'image'},
                {data: 'category_id', name: 'category_id'},
                {data: 'price', name: 'price'},
                {data: 'stock', name: 'stock'},
                {data: 'sku', name: 'sku'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#image').on('change', function() {
            var file = this.files[0];
            $("#image").next('.custom-file-label').html(file.name);
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result).show();
            }
            reader.readAsDataURL(file);
        });

        $('#modelId').on('hidden.bs.modal', function () {
            $('#product-add')[0].reset();
            $('#preview').attr('src', '').hide();
            $('#modelId').find('.modal-title').text('Create Product');
            $('#submit').text('Submit');
            $('#product-add').attr('action', '{{ route('products.store') }}');
        });

        $("#product-add").on('submit', function(e){
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
                        $('#product-add')[0].reset();
                        $('#modelId').modal('hide');
                        table.ajax.reload();
                    } else {
                        alert(data.message);
                    }
                },
                error: function(err){
                    alert('Something went wrong. Please try again later.');
                }
            });
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

    function edit(id) {
    var url = "{{ url('/') }}" + '/products/edit/' + id;
    $.ajax({
        type: "GET",
        url: url,
        success: function (data) {
            if(data.status){
                var product = data.data;
                $('#name').val(product.name);
                $('#category_id').val(product.category_id);
                $('#subcategory_id').val(product.subcategory_id); // Add this line
                $('#price').val(product.price);
                $('#stock').val(product.stock);
                $('#sku').val(product.sku);
                $('#status').val(product.status);
                $('#preview').attr('src', '{{ asset('/') }}' + product.image).show();
                $('#modelId').find('.modal-title').text('Edit Product');
                $('#submit').text('Update');
                $('#product-add').attr('action', '{{ url('/') }}/products/update/' + id);
                $('#modelId').modal('show');
            } else {
                alert(data.message);
            }
        },
        error: function(err){
            alert('Something went wrong. Please try again later.');
        }
    });
}
</script>
@endpush
