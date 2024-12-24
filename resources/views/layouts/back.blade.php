<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"  />

   <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.cs')}}s">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/izitoast/css/iziToast.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/chocolat/dist/css/chocolat.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css')}}">
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
   <style>
       @keyframes barWidth {
            0%   {width: 0%;}
            25%  {width: 25%;}
            50%  {width: 50%;}
            75%  {width: 75%;}
            100% {width: 100%;}
        }

      .border{
            border-top: 5px solid #6777ef;
            display: none;
            animation: barWidth;
            animation-duration: 1s;
            animation-timing-function: linear;
        }
   </style>
    @stack('styles')


</head>

<body @if(Route::is('pos*')) class="sidebar-mini" @endif>
  <div id="app">
    <div class="border"></div>
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        @include('inc.topbar')
        @include('inc.sidebar')
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            @yield('content')

          </section>
        </div>
      </div>

  </div>
  @stack('modals')

  <!-- General JS Scripts -->
  <script src="{{ asset('backend/assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/popper.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/stisla.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/sweetalert/sweetalert.min.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('backend/assets/modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/chart.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{ asset('backend/assets/modules/izitoast/js/iziToast.min.js') }}"></script>

  <script src="{{ asset('backend/assets/modules/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
  <script src="{{ asset('backend/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <!-- Page Specific JS File -->

  <!-- Template JS File -->
  <script src="{{ asset('backend/assets/js/scripts.js')}}"></script>
  <script src="{{ asset('backend/assets/js/custom.js')}}"></script>

  <script src="{{asset('backend/assets/js/printThis.js')}}"> </script>
  @php
    $data = App\Models\Order::where('store_id', Auth::user()->store_id)
        ->whereBetween('created_at',  [\Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::SUNDAY), \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SATURDAY)])
        ->selectRaw('sum(total_amount) as total_amount, created_at')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->get();

    $expenses = App\Models\Expense::where('store_id', Auth::user()->store_id)
        ->whereBetween('created_at',  [\Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::SUNDAY), \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SATURDAY)])
        ->selectRaw('sum(expense_amount) as expense_amount, created_at')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->get();

    $days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    $total = [];
    $expense = [];
    foreach ($data as $key => $value) {
        $total[] = $value->total_amount;
    }
    foreach ($expenses as $key => $value) {
        $expense[] = $value->expense_amount;
    }
  @endphp
  @include('notification.toast')
   <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
   <script>
    // ChartJS
    var statistics_chart = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(statistics_chart, {
    type: 'line',
    data: {
        labels: {!! json_encode($days) !!},
        datasets: [
            {
                label: 'Orders',
                data: {!! json_encode($total) !!},
                borderWidth: 3,
                borderColor: '#6777ef',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6777ef',
                pointRadius: 2,
            },
            {
                label: 'Expense',
                data: {!! json_encode($expense) !!},
                borderWidth: 3,
                borderColor: '#fc544b',
                backgroundColor: 'transparent',
                pointBackgroundColor: '#fff',
                pointBorderColor: '#fc544b',
                pointRadius: 2,
            },

        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
    });


    function printDiv(elem) {
        $('.border').show();
        $(elem).printThis({
            beforePrintEvent: function(){
                console.log('beforePrint');
            },
        });
    }

    function printReceipt(id) {
        $.ajax({
            type: "POST",
            url: "{{ route('orders.receipt') }}",
            data: {id: id,
                _token:"{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (response) {
                if(response.status){
                    printDiv(response.receipt);

                } else {
                    iziToast.error({title: 'Error',timeout: 1500,message: response.message,position: 'topRight'});
                }
            }
        });
    }
   </script>
    @stack('scripts')



</body>
</html>
