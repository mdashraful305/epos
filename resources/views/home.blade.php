
@extends('layouts.back')
@section('title', 'Dashboard')
@section('content')
@php

$today_sales=App\Models\Order::where('store_id', Auth::user()->store_id)
                ->whereDate('created_at', \Carbon\Carbon::today())
                ->sum('total_amount');
$this_week_sales=App\Models\Order::where('store_id', Auth::user()->store_id)
                ->whereBetween('created_at', [\Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::SUNDAY), \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SATURDAY)])
                ->sum('total_amount');
$this_month_sales=App\Models\Order::where('store_id', Auth::user()->store_id)
                ->whereMonth('created_at', \Carbon\Carbon::now()->month)
                ->sum('total_amount');
$this_year_sales=App\Models\Order::where('store_id', Auth::user()->store_id)
                ->whereYear('created_at', \Carbon\Carbon::now()->year)
                ->sum('total_amount');

$orders=App\Models\Order::where('store_id', Auth::user()->store_id)
                ->latest()->take(4)->get();
$total_orders=App\Models\Order::where('store_id', Auth::user()->store_id)->count();
$customers=App\Models\Customer::where('store_id', Auth::user()->store_id)->count();
$total_sales=App\Models\Order::where('store_id', Auth::user()->store_id)->sum('total_amount');
$total_expense=App\Models\Expense::where('store_id', Auth::user()->store_id)->sum('expense_amount');

@endphp

<section class="section">
    <div class="section-header">
      <h1>Dashboard</h1>
    </div>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-user"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Orders</h4>
            </div>
            <div class="card-body">
              {{ $total_orders }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="far fa-newspaper"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Customers</h4>
            </div>
            <div class="card-body">
              {{  $customers}}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="far fa-file"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Sales</h4>
            </div>
            <div class="card-body">
             {{ $total_sales }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-circle"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Expense</h4>
            </div>
            <div class="card-body">
              {{ $total_expense }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-8 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Statistics</h4>
              <div class="card-header-action">
                <div class="btn-group">
                  <a href="#" class="btn btn-primary">Week</a>
                </div>
              </div>
            </div>
            <div class="card-body"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
              <canvas id="myChart" height="1746" style="display: block; width: 1440px; height: 873px;" width="2880" class="chartjs-render-monitor"></canvas>
              <div class="statistic-details mt-sm-4">
                <div class="statistic-details-item">
                  {{-- <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span> --}}
                  <div class="detail-value">{{ $today_sales }}</div>
                  <div class="detail-name">Today's Sales</div>
                </div>
                <div class="statistic-details-item">
                  {{-- <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span> --}}
                  <div class="detail-value">{{ $this_week_sales }}</div>
                  <div class="detail-name">This Week's Sales</div>
                </div>
                <div class="statistic-details-item">
                  {{-- <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span> --}}
                  <div class="detail-value">{{  $this_month_sales }}</div>
                  <div class="detail-name">This Month's Sales</div>
                </div>
                <div class="statistic-details-item">
                  {{-- <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span> --}}
                  <div class="detail-value">{{ $this_year_sales }}</div>
                  <div class="detail-name">This Year's Sales</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12 col-12 col-sm-12">
          <div class="card">
            <div class="card-header">
              <h4>Recent Orders</h4>
            </div>
            <div class="card-body">
              <ul class="list-unstyled list-unstyled-border">
                @forelse ($orders as $item)
                    <li class="media">
                        <div class="media-body">
                        <div class="float-right text-primary">{{ $item->created_at->diffForHumans();}}</div>
                        <div class="media-title">#{{$item->id }} - By {{ $item->customer->name }}</div>
                        <span class="text-small text-muted">Price : {{ $item->total_amount }}</span>
                        </div>
                    </li>
                @empty

                @endforelse

              </ul>
              <div class="text-center pt-1 pb-1">
                <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg btn-round">
                  View All
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
@endsection
