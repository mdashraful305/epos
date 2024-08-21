@extends('layouts.back')
@section('title', 'Manage Expenses')
@push('scripts')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Manage Expenses</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Expenses</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Expenses List</h4>
                            <div class="card-header-form">
                                @can('create-expense')
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm my-2" data-toggle="modal"
                                        data-target="#expenseModal"><i class="bi bi-plus-circle"></i> +Add New Expense</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="expense-table" class="table dataTable no-footer table-hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>S#</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Amount</th>
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
    <div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="expenseModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('expenses.store') }}" method="POST" id="expense-add">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="expense_date">Date</label>
                            <input type="date" class="form-control" name="expense_date" id="expense_date" required>
                        </div>

                        <div class="form-group">
                            <label for="expense_category">Select Category</label>
                            <input list="expense-categories" id="expense_category" class="form-control" name="expense_category" required>
                            <datalist id="expense-categories">
                                @php
                                $categories = [
                                    'Rent',
                                    'Utilities',
                                    'Cleaning Services',
                                    'Salaries and Wages',
                                    'Employee Benefits',
                                    'Training and Development',
                                    'Travel and Accommodation',
                                    'Employee Reimbursements',
                                    'Advertising',
                                    'Promotions',
                                    'Public Relations',
                                    'Digital Marketing',
                                    'Software Licenses',
                                    'IT Support',
                                    'Website Maintenance',
                                    'Hardware Purchases',
                                    'Bank Fees',
                                    'Legal Fees',
                                    'Accounting and Auditing',
                                    'Taxes',
                                    'Insurance',
                                    'Raw Materials',
                                    'Finished Goods',
                                    'Freight and Shipping',
                                    'Packaging',
                                    'Depreciation',
                                    'Leasing',
                                    'Transportation',
                                    'Security',
                                    'Subscriptions',
                                    'Donations and Sponsorships',
                                    'Gifts and Entertainment',
                                    'Miscellaneous',
                                ];
                                @endphp
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="expense_description">Description</label>
                            <textarea class="form-control" name="expense_description" id="expense_description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="expense_amount">Amount</label>
                            <input type="number" class="form-control" name="expense_amount" id="expense_amount" required>
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

            var table = $('#expense-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('expenses.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'expense_date', name: 'expense_date' },
                    { data: 'expense_category', name: 'expense_category' },
                    { data: 'expense_description', name: 'expense_description' },
                    { data: 'expense_amount', name: 'expense_amount' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            $('#expenseModal').on('hidden.bs.modal', function() {
                $('#expense-add')[0].reset();
                $('#expenseModal').find('.modal-title').text('Create Expense');
                $('#submit').text('Submit');
                $('#expense-add').attr('action', '{{ route('expenses.store') }}');
            });

            $("#expense-add").on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status) {
                            iziToast.success({
                                title: 'Success',
                                timeout: 1500,
                                message: data.message,
                                position: 'topRight'
                            });
                            $('#expenseModal').modal('hide');
                            table.draw();
                            $('#expense-add')[0].reset();
                        } else {
                            iziToast.error({
                                title: 'Error',
                                timeout: 1500,
                                message: data.message,
                                position: 'topRight'
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err.responseJSON);
                        if (err.status === 422) {
                            var errors = err.responseJSON.errors;
                            // Display errors to the user
                            $.each(errors, function(key, value) {
                                iziToast.error({
                                    title: 'Error',
                                    timeout: 1500,
                                    message: value,
                                    position: 'topRight'
                                });
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                timeout: 1500,
                                message: 'Something went wrong. Please try again later',
                                position: 'topRight'
                            });
                        }
                    }
                });
            });

        });

        function checkDelete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            var url = "{{ url('/') }}" + '/expenses/destroy/' + id;
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
                            data: { "id": id, "_token": token },
                            success: function(data) {
                                if (data.status) {
                                    iziToast.success({
                                        title: 'Success',
                                        timeout: 1500,
                                        message: data.message,
                                        position: 'topRight'
                                    });
                                    $('#expense-table').DataTable().ajax.reload();
                                } else {
                                    iziToast.error({
                                        title: 'Error',
                                        timeout: 1500,
                                        message: data.message,
                                        position: 'topRight'
                                    });
                                }
                            },
                            error: function(err) {
                                iziToast.error({
                                    title: 'Error',
                                    timeout: 1500,
                                    message: 'Something went wrong. Please try again later',
                                    position: 'topRight'
                                });
                            }
                        });
                    }
                });
        };

        function edit(id) {
            var id = id;
            var url = "{{ url('/') }}" + '/expenses/edit/' + id;
            $.ajax({
                type: "GET",
                url: url,
                success: function(data) {
                    if (data.status) {
                        $('#expenseModal').modal('show');
                        $('#expenseModal').find('.modal-title').text('Update Expense');
                        $('#expense-add').attr('action', '{{ url('/') }}/expenses/update/' + id);
                        $('#expense_date').val(data.data.expense_date);
                        $('#expense_category').val(data.data.expense_category);
                        $('#expense_description').val(data.data.expense_description);
                        $('#expense_amount').val(data.data.expense_amount);
                        $('#submit').text('Update');
                    } else {
                        iziToast.error({
                            title: 'Error',
                            timeout: 1500,
                            message: data.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(err) {
                    console.log(err);
                    iziToast.error({
                        title: 'Error',
                        timeout: 1500,
                        message: 'Something went wrong. Please try again later',
                        position: 'topRight'
                    });
                }
            });
        }
    </script>
@endpush
