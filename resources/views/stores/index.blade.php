@extends('layouts.back')
@section('title', 'Manage Stores')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage Stores</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Stores</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Stores    </h4>
                  <div class="card-header-form">
                    @can('create-product')
                    <a href="{{ route('stores.create') }}" class="btn btn-success btn-sm my-2" ><i class="bi bi-plus-circle"></i> +Add New Category</a>
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
                          <th>Phone</th>
                          <th>Image</th>
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
            ajax: "{{ route('stores.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "fnDrawCallback": function() {
              $('.toggle-demo').bootstrapToggle();
            },

        });
    });

</script>
@endpush
