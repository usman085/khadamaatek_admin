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

        .dataTables_wrapper{
            overflow-x: hidden;
        }
        select[name="datatable_length"] {
            min-width: 60px;
        }
    </style>
@endsection
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header {{$current_locale == "en"? '':'align-right'}}">
                        @if($current_locale == "en")
                        <i class="fa fa-align-justify"></i> @lang('customer.customers')
                        @else
                            @lang('customer.customers') <i class="fa fa-align-justify"></i>
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
                        <div class="col-lg-12 {{$current_locale == "en"? '':'align-right'}}" style="padding: 0px;">
                            <a href="{{ route('customers.create') }}" class="btn btn-primary m-2">@lang('customer.addNewCustomer')</a>
                        </div>
                    <br>
                        <table class="table table-responsive table-striped" id="datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>Sr#</th>
                                    <th>@lang('common.name')</th>
                                    <th>@lang('customer.account')</th>
                                    <th>@lang('customer.email')</th>
                                    <th>@lang('customer.gender')</th>
                                    <th>@lang('customer.nationality')</th>
                                    <th>@lang('customer.phone_no')</th>
                                    <th>@lang('customer.MemberSince')</th>
                                    <th>@lang('customer.LastSeen')</th>
                                    <th>@lang('customer.Balance')</th>
                                    <th>@lang('customer.TotalOrders')</th>
                                    <th>@lang('customer.TotalTransaction')</th>
                                    <th>@lang('common.edit')</th>
                                    <th>@lang('common.delete')</th>

                                </tr>
                            @else
                                <tr class="align-right">
                                    <th>@lang('common.delete')</th>
                                    <th>@lang('common.edit')</th>
                                    <th>@lang('customer.TotalTransaction')</th>
                                    <th>@lang('customer.TotalOrders')</th>
                                    <th>@lang('customer.Balance')</th>
                                    <th>@lang('customer.LastSeen')</th>
                                    <th>@lang('customer.MemberSince')</th>
                                    <th>@lang('customer.phone_no')</th>
                                    <th>@lang('customer.nationality')</th>
                                    <th>@lang('customer.gender')</th>
                                    <th>@lang('customer.email')</th>
                                    <th>@lang('customer.account')</th>
                                    <th>@lang('common.name')</th>
                                    <th>Sr#</th>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @foreach($customers as $customer)
                                    @if($locale_array[$current_locale] == "English" )
                                        <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                        <td><strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></td>
                        <td>{{ $customer->account_no }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>
                        @if ($customer->gender == 'Male')
                             @lang('customer.Male')
                        @endif
                        @if ($customer->gender == 'Female')
                             @lang('customer.Female')
                        @endif
                        @if ($customer->gender == 'Other')
                             @lang('customer.Other')
                        @endif
             
                        </td>
                        <td>{{ $customer->nationality }}</td>
                        <td>{{ $customer->phone_no }}</td>
                        <td>
                        @if($customer->email_verified_at)
                       @php 
                       echo Carbon\Carbon::parse($customer->email_verified_at)->format('Y-m-d')
                       @endphp
                       
                        @else
                        -
                        @endif
                        </td>
                        <td>{{ $customer->last_login }}</td>
                        <td>{{ $customer->balance}}</td>
                        <td>{{ $customer->all_orders }}</td>
                     

                        <td>{{ $customer->transactionDetail }}</td>

                        
                        
                        <td>
                            <a href="{{ url('/admin/customers/' . $customer->id . '/edit') }}"
                                class="btn btn-primary">@lang('common.edit')</a>
                        </td>
                        <td>
                            <form class="form" action="{{ route('customers.destroy', $customer->id ) }}"
                              method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">@lang('common.delete')</button>
                            </form>
                            <div id="confirmBox">
                                            <div class="message"></div>
                                            <div class="cover">
                                            <button class="button btn btn-primary  yes">@lang('common.Ok')</button>
                                            <button class="button btn btn-danger no ">@lang('common.Cancel')</button>

                                            </div>
                                        </div>
                        </td>
                        </tr>
                                    @else
                                        <tr class="align-right">
                                            <td>
                                                <form class="form" action="{{ route('customers.destroy', $customer->id ) }}"
                                                      method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger">@lang('common.delete')</button>
                                                </form>
                                                <div id="confirmBox">
                                                    <div class="message"></div>
                                                    <div class="cover">
                                                        <button class="button btn btn-primary  yes">@lang('common.Ok')</button>
                                                        <button class="button btn btn-danger no ">@lang('common.Cancel')</button>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/customers/' . $customer->id . '/edit') }}"
                                                   class="btn btn-primary">@lang('common.edit')</a>
                                            </td>
                                            <td>{{ $customer->transactionDetail }}</td>
                                            <td>{{ $customer->all_orders }}</td>
                                            <td>{{ $customer->balance}}</td>
                                            <td>{{ $customer->last_login }}</td>
                                            <td>
                                                @if($customer->email_verified_at)
                                                    @php
                                                        echo Carbon\Carbon::parse($customer->email_verified_at)->format('Y-m-d')
                                                    @endphp

                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $customer->phone_no }}</td>
                                            <td>{{ $customer->nationality }}</td>
                                            <td>
                                                @if ($customer->gender == 'Male')
                                                    @lang('customer.Male')
                                                @endif
                                                @if ($customer->gender == 'Female')
                                                    @lang('customer.Female')
                                                @endif
                                                @if ($customer->gender == 'Other')
                                                    @lang('customer.Other')
                                                @endif

                                            </td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->account_no }}</td>
                                            <td><strong>{{ $customer->first_name }} {{ $customer->last_name }}</strong></td>
                                            <td><strong>{{ $i++ }}</strong></td>

                                        </tr>
                                    @endif
                        @endforeach
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



$('#datatable').DataTable({
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[12,13 ]:[0,1] },
    ],
    language: {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
      
    }
})
</script>
@endsection