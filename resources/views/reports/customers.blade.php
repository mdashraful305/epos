@extends('layouts.back')
@section('title', 'Customers Reports')
@section('content')
<section class="section">
    <div class="section-header">
      <h1>Customers Reports</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Reports</div>
      </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Reports</h4>
                  <div class="card-header-form">
                  </div>
                </div>
                <div class="card-body">
                    <form id="filterForm" class="py-3">
                        <div class="row">
                            <div class="col">
                                <label for="start_date">Start Date</label>
                                <input class="form-control" type="date" id="start_date" name="start_date">
                            </div>
                            <div class="col">
                                <label for="end_date">End Date</label>
                                <input class="form-control" type="date" id="end_date" name="end_date">
                            </div>
                            <div class="col">
                                <label for="end_date">&nbsp;</label><br>
                                <button type="submit" id="filterButton" class="btn btn-primary">Filter</button>
                            </div>
                          </div>

                    </form>
                  <div class="table-responsive">
                    <table class="table table-striped" id="data-table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Profit</th>
                            <th>Total Amount</th>
                            <th>Total Orders</th>
                        </tr>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot class="bg-secondary">
                        <tr>
                            <th></th>
                            <th>Total  : </th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                      </tfoot>
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


@endpush
@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            bAutoWidth:false,
            dom:'lBfrtip',
            ajax: {
                url: '{{ route('reports.customers') }}',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'customer_name', name: 'customer_name' },
                { data: 'total_profit', name: 'total_profit' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'total_orders', name: 'total_orders' },
           ],
              "footerCallback": function ( row, data, start, end, display ) {
                 var api = this.api(), data;
                 var intVal = function ( i ) {
                      return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                             i : 0;
                 };
                 total_profit = api.column(2).data().reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                 }, 0 );
                 $total_amount = api.column(3).data().reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                    }, 0 );
                    $( api.column(2).footer() ).html(total_profit);
                    $( api.column(3).footer() ).html($total_amount);
                },
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]

        }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

        // Handle filter form submit
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
           var table=$('#data-table').DataTable();
            table.draw();
        });
    });

</script>
@endpush
