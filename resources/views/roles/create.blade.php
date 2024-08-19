@extends('layouts.back')
@section('title', 'Add New Role')
@push('styles')
@endpush
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Manage User</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Roles</div>
      </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Role</h4>
                        <div class="card-header-form">
                            <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="post">
                            @csrf

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('permissions') is-invalid @enderror select2" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                                        @forelse ($permissions as $permission)
                                            <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @empty

                                        @endforelse
                                    </select>
                                    @if ($errors->has('permissions'))
                                        <span class="text-danger">{{ $errors->first('permissions') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
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
    $(document).ready(function() {
        const addSelectAll = matches => {
            if (matches.length > 0) {
            // Insert a special "Select all matches" item at the start of the
            // list of matched items.
            return [
                {id: 'selectAll', text: 'Select all matches', matchIds: matches.map(match => match.id)},
                ...matches
            ];
            }
        };
        const handleSelection = event => {
            if (event.params.data.id === 'selectAll') {
            $('.select2').val(event.params.data.matchIds);
            $('.select2').trigger('change');
            };
        };
        $('.select2').select2({
            multiple: true,
            sorter: addSelectAll,
        });
        $('.select2').on('select2:select', handleSelection);
    });
</script>

@endpush
