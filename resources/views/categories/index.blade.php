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
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
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
    });
  </script>
@endpush
