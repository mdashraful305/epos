@extends('layouts.back')
@section('title', 'Add New Catetory')
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Create Catetory</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Catetory</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Catetory</h4>
                        <div class="card-header-form">
                            <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categories.store') }}" method="POST" id="cate-add">
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

                            <div class="mb-3 row">
                                <button type="submit" class="col-md-3 offset-md-5 btn btn-primary float-right" value="Add Catetory">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
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
                        iziToast.success(message: data.message);
                    }else{
                        iziToast.error(message: data.message);
                    }
                },
                error: function(err){
                    if (err.status === 422) {
                        var errors = err.responseJSON.errors;
                        // Display errors to the user
                        $.each(errors, function(key, value) {
                            iziToast.error(message: value);
                        });
                    }else{
                        iziToast.error(message: 'Something went wrong on the server.');
                    }
                }
            });
        });
</script>

@endpush
