@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('customers') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
@section('css')
<style>
select[name="log-table_length"] {
    min-width: 60px;
}
.dataTables_wrapper{
    overflow-x: hidden;
}
</style>
@if($locale_array[$current_locale] == "Arabic" )
    <style>
        .odd{
            text-align: right;
        }
        .even{
            text-align: right;
        }
    </style>
    @endif
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header {{$current_locale == "en"? '':'align-right'}}">
                        @if($current_locale == "en")
                        <i class="fa fa-align-justify"></i> @lang('customer.logReport')
                        @else
                            @lang('customer.logReport') <i class="fa fa-align-justify"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(Session::has('message'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-3">
                                <input id="startDate" class="form-control" placeholder=" @lang('customer.fromDate')" />
                            </div>
                            <div class="col-md-3">
                                <input id="endDate" class="form-control" placeholder="@lang('customer.toDate')" />
                            </div>
                            <div class="col-md-3">
                                <select class="form-control select2" id="customer">
                                    <option value="" selected disabled>@lang('customer.chooseCustomer')</option>
                                    @foreach ($customers as $cust)
                                    <option value="{{ $cust->id }}">{{ $cust->first_name . ' ' . $cust->last_name  }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-md btnSearch"><i class="fas fa-search"></i>
                                    @lang('customer.search')</button>
                            </div>
                        </div>
                        <br>
                        <table class="table table-responsiv table-striped" id="log-table">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th style="width: 10%">Sr#</th>
                                    <th style="width: 20%">@lang('customer.customerName')</th>
                                    <th>@lang('customer.action')</th>
                                    <th style="width: 20%">@lang('customer.createdAt')</th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th style="width: 20%">@lang('customer.createdAt')</th>
                                    <th>@lang('customer.action')</th>
                                    <th style="width: 20%">@lang('customer.customerName')</th>
                                    <th style="width: 10%">Sr#</th>
                                </tr>
                            @endif
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

@endsection


@section('javascript')
<script>
fetchCustomerLogs(true);
var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
$('#startDate').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd',
    iconsLibrary: 'fontawesome',
    maxDate: function() {
        return $('#endDate').val();
    }
});
$('#endDate').datepicker({
    uiLibrary: 'bootstrap4',
    format: 'yyyy-mm-dd',
    iconsLibrary: 'fontawesome',
    minDate: function() {
        return $('#startDate').val();
    }
});

$('.btnSearch').on('click', fetchCustomerLogs);

function fetchCustomerLogs(show_all = false) {
    $("#log-table").dataTable().fnDestroy();

    const start_date = $('#startDate').val();
    const end_date = $('#endDate').val();
    const user_id = $('#customer').val();

    if (show_all || (start_date && end_date && user_id)) {
        $('#log-table').DataTable({
            processing: true,
            serverSide: true,
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[1 ]:[2 ]  },
            ],
            "order": [[ 3, "desc" ]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
            },
            ajax: {
                url: '{{ route("customer.fetchlogs") }}',
                type: 'GET',
                data: function(d) {
                    d.start_date = $('#startDate').val();
                    d.end_date = $('#endDate').val();
                    d.user_id = $('#customer').val();
                }
            },

            columns:
                "{{$current_locale}}"=='en'?
                    [
                        {
                        data: 'id',
                        name: 'id'
                        },
                        {
                            data: 'full_name',
                            name: 'full_name'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        }
                    ]:[
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                        {
                            data: 'full_name',
                            name: 'full_name'
                        },
                        {
                            data: 'id',
                            name: 'id'
                        },
                    ]

        });
    } else {
        alert("Please Choose all detail!");
    }
}
</script>
<script>

</script>
@endsection