@extends('dashboard.base')

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@endsection

@section('content')
<style>
    .text-value-title {
        font-size: 18px;
        font-weight: 500
    }

</style>

<div class="container-fluid">
    @php
        $current_locale = Session::get('current_locale','en');
        $locale_array = ['en'=>'English','ar'=>'Arabic']
    @endphp
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-info">
                    <a href="{{ route('order.index') }}" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $total_services }}</div>
                                <div class="text-value-title">@lang('dashboard.totalServices')</div>
                            @else
                                <div class="text-value-lg align-right">{{ $total_services }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalServices')</div>
                            @endif
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart1" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-warning">
                    <a href="{{ route('order.index') }}?status=1" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $pending_orders }}</div>
                                <div class="text-value-title">@lang('dashboard.totalPending')</div>
                                @else
                                <div class="text-value-lg align-right">{{ $pending_orders }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalPending')</div>
                                @endif

                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart2" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-info">
                    <a href="{{ route('order.index') }}?status=2" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $inprocess_orders }}</div>
                                <div class="text-value-title">@lang('dashboard.totalInProcess')</div>
                            @else
                                <div class="text-value-lg align-right">{{ $inprocess_orders }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalInProcess')</div>
                            @endif
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart3" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-primary">
                    <a href="{{ route('order.index') }}?status=3" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $confirmed_orders }}</div>
                                <div class="text-value-title">@lang('dashboard.totalConfirmed')</div>
                            @else
                                <div class="text-value-lg align-right">{{ $confirmed_orders }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalConfirmed')</div>
                            @endif
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart4" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-success">
                    <a href="{{ route('order.index') }}?status=4" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $completed_orders }}</div>
                                <div class="text-value-title">@lang('dashboard.totalCompleted')</div>
                            @else
                                <div class="text-value-lg align-right">{{ $completed_orders }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalCompleted')</div>
                            @endif
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart5" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-4">
                <div class="card text-white bg-danger">
                    <a href="{{ route('order.index') }}?status=5" class="text-white text-decoration-none">
                        <div class="card-body pb-0">
                            @if($locale_array[$current_locale] == "English" )
                                <div class="text-value-lg">{{ $cancelled_orders }}</div>
                                <div class="text-value-title">@lang('dashboard.totalCancelled')</div>
                            @else
                                <div class="text-value-lg align-right">{{ $cancelled_orders }}</div>
                                <div class="text-value-title align-right">@lang('dashboard.totalCancelled')</div>
                            @endif
                        </div>
                        <div class="c-chart-wrapper mt-3" style="height:70px;">
                            <canvas class="chart-style" id="card-chart6" height="70"></canvas>
                        </div>
                    </a>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
</div>

@endsection

@section('javascript')

<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
<script src="{{ asset('js/main.js') }}" defer></script>
@endsection
