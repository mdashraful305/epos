@extends('layouts.back')
@section('title', 'Edit Product')
@push('styles')
@endpush
@section('content')
  @if($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                iziToast.error({title: 'Error',timeout: 1500,message: $error,position: 'topRight'});
            </script>
        @endforeach
    @endif

    <section class="section">
        <div class="section-header">
            <h1>Edit Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Product</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Product</h4>
                            <div class="card-header-form">
                                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('products.update',$product->id) }}" method="POST" id="product-add"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{ $product->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="description" id="description" >{{ $product->description }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="price">Sell Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="price" id="price" placeholder="Enter Price" value="{{ $product->price }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="original_price">Original Price <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="original_price" id="original_price" placeholder="Enter Original Price" value="{{ $product->original_price }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="stock">Discount Type</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <div class="form-group">
                                                                <select class="form-control"  name="discount_type"  id="discount_type">
                                                                    <option value="">Select Type</option>
                                                                    <option value="percentage" @if($product->discount_type=='percentage') selected @endif>Percentage</option>
                                                                    <option value="flat" @if($product->discount_type=='flat') selected @endif>Flat</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="number" class="form-control" name="discount_value" id="discount_value" placeholder="Enter Value" value="{{ $product->discount_value}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="discounted_price">Discount Price</label>
                                                    <input type="number" class="form-control" name="discounted_price" id="discounted_price" placeholder="Enter Discount" readonly value="{{ $product->discounted_price}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="unit">Unit <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Enter Unit ( Like: Pc,Kg)" value="{{ $product->unit  }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="stock">Stock <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="stock" id="stock" placeholder="Enter Stock" value="{{ $product->stock }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sku">SKU <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="sku" id="sku" placeholder="Enter SKU" value="{{ $product->sku }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="category_id">Category <span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="category_id" id="category_id"
                                                aria-label="Category" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @if($category->id==$product->category_id) selected @endif>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="subcategory_id">Sub Category</label>
                                            <select class="form-control select2" name="subcategory_id"id="subcategory_id" >
                                                @if($product->subcategory_id==Null)
                                                    <option value="" selected>No Subcategory Selected</option>
                                                    @foreach ($product->category?->subcategories as $item)
                                                        <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Select Subcategory</option>
                                                    @foreach ($product->category?->subcategories as $item)
                                                        <option value="{{ $item->id }}" @if($item->id==$product->subcategory_id) selected @endif>{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="image">Image <span class="text-danger">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="image" accept="image/*" @if($product->image==Null)required @endif>
                                                <label class="custom-file-label" for="image">Choose file</label>
                                            </div>
                                            <div class="image-preview mt-2" style="@if($product->image==Null)display: none @endif">
                                                <img src="{{ asset($product->image) }}" alt="" id="preview" width="100%">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select class="form-control" name="status" id="status" required>
                                                <option value="1" @if($product->status==1) selected @endif>Active</option>
                                                <option value="0" @if($product->status==0) selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group d-flex justify-content-end" style="gap:15px">
                                            <a href="{{ route('products.index') }}" class="btn btn-md btn-danger ">Cancel</a>
                                            <button type="button" class="btn btn-md btn-primary ">Reset</button>
                                            <button type="submit" class="btn btn-md btn-primary ">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                minHeight: 150,
            });
            $('.select2').select2({
                width: '100%'
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
    </script>
    <script>
        $(document).ready(function () {
            $("#category_id").change(function (e) {
                e.preventDefault();
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ route('products.subcategories') }}",
                    type: "POST",
                    data: {
                        category_id: category_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status) {
                            if(response.data.length > 0){
                                $("#subcategory_id").prop('disabled', false);
                                $("#subcategory_id").html('<option value="">Select Subcategory</option>');
                                response.data.forEach(element => {
                                    $("#subcategory_id").append('<option value="'+element.id+'">'+element.name+'</option>');
                                });

                            }else{
                                $("#subcategory_id").prop('disabled', true);
                                $("#subcategory_id").html('<option value="null">No Subcategory Found</option>');
                            }
                        } else {
                            $("#subcategory_id").prop('disabled', true);
                            $("#subcategory_id").html('<option value="">Select Category First</option>');
                        }
                    }
                });

            });

            $("#discount_type").change(function (e) {
                e.preventDefault();
                var price = $("#price").val();
                var discount_type = $(this).val();
                var discount_value = $("#discount_value").val();
                var discounted_price = 0;
                if(discount_type == 'percentage'){
                    discounted_price = price - (price * discount_value / 100);
                }else if(discount_type == 'flat'){
                    discounted_price = price - discount_value;
                }else{
                    discounted_price = price;
                    $("#discount_value").val('');
                }
                $("#discounted_price").val(discounted_price);
            });
            $("#discount_value").keyup(function (e) {
                e.preventDefault();
                var price = $("#price").val();
                var discount_type = $("#discount_type").val();
                var discount_value = $(this).val();
                var discounted_price = 0;
                if(discount_type == 'percentage'){
                    discounted_price = price - (price * discount_value / 100);
                }else if(discount_type == 'flat'){
                    discounted_price = price - discount_value;
                }else{
                    discounted_price = price;
                    $("#discount_value").val('');
                }
                $("#discounted_price").val(discounted_price);

            });
        });
    </script>
@endpush
