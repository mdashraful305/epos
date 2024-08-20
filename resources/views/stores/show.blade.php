@extends('layouts.back')
@section('title', 'Store Profile')
@push('styles')
@endpush
@section('content')

<section class="section">
    <div class="section-header">
      <h1>Store Profile</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Store Profile</div>
      </div>
    </div>
    <div class="section-body">
      <h2 class="section-title">Hi, {{ $store->name }}</h2>
      <p class="section-lead">
        Change information about your store on this page.
      </p>

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget">
            <div class="profile-widget-header">
              <img alt="image" src="{{ asset($store?->image ?? 'backend/assets/img/avatar/avatar-1.png') }}" class="rounded-circle profile-widget-picture">
            </div>
            <div class="profile-widget-description">
                <div class="mb-3 row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $store->name }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone :</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $store->phone }}
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="text" class="col-md-4 col-form-label text-md-end text-start"><strong>Address :</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $store->address }}
                    </div>
                </div>


            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card">
            <form method="post" action="{{ route('stores.update', $store->id) }}" id="store-update">
                @csrf
              <div class="card-header">
                <h4>Edit Store Profile</h4>
              </div>
              <div class="card-body">
                <div class="mb-3 row">
                    <label for="name" class="col-md-2 col-form-label text-md-end text-start">Name</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $store->name }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-2 col-form-label text-md-end text-start">Email Address</label>
                    <div class="col-md-10">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $store->user->email }}" disabled>

                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="description" class="col-md-2 col-form-label text-md-end text-start">Description <span class="text-danger">*</span></label>
                    <div class="col-md-10">
                        <textarea class="form-control" name="description" id="description" placeholder="Enter Description">{{ old('description') }}</textarea>

                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="phone" class="col-md-2 col-form-label text-md-end text-start">Phone</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ $store->phone }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="image" class="col-md-2 col-form-label text-md-end text-start">Image</label>
                    <div class="col-md-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" id="image" accept="image/*">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="image-preview mt-2" style="display: none">
                            <img src="" alt="" id="preview" width="100%">
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="phone" class="col-md-2 col-form-label text-md-end text-start">Address</label>
                    <div class="col-md-10">
                      <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ $store->address }}">
                    </div>
                </div>

              </div>
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@push('scripts')
    <script>
       $(document).ready(function() {
            $("#description").summernote({
                dialogsInBody: true,
                minHeight: 80,
            });
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

        $("#store-update").on('submit', function(e){
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
                        console.log(data);
                        iziToast.success({title: 'Success',timeout: 1500,message: data.message,position: 'topRight'});
                        $('#name').val(data.store.name);
                        $('#phone').val(data.store.phone);
                        $('#address').val(data.store.address);
                        var image="{{ asset('') }}"+data.store.image;
                        $('#description').summernote('code', data.store.description);
                        $('.image-preview').hide();
                        $('.profile-widget-picture').attr('src', image);

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
    </script>
@endpush

