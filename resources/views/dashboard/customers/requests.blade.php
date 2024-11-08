@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('customers') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
<style>
.pending{
    display: inline-block;
    padding: 0 5px;
    height: 15px;
    font-size: 11px;
    line-height: 15px;
    border-radius: 25px;
    background-color: #2196f3;
    color: white;
    font-weight: 600;

}
.aprooved{
    display: inline-block;
    padding: 0 5px;
    height: 15px;
    font-size: 11px;
    line-height: 15px;
    border-radius: 25px;
    background-color: #008000bf;
    color: white;
    font-weight: 600;

}
.cancel{
    display: inline-block;
    padding: 0 5px;
    height: 15px;
    font-size: 11px;
    line-height: 15px;
    border-radius: 25px;
    background-color: #ff0000b8;
    color: white;
    font-weight: 600;

}
select[name="datatable_length"] {
    min-width: 60px;
}
</style>
@section('css')
    <style>
        .dataTables_wrapper{
            overflow-x: hidden;
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
                        <i class="fa fa-align-justify"></i>@lang('customer.customerRequest')
                        @else
                            @lang('customer.customerRequest') <i class="fa fa-align-justify"></i>
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
                        <br>
                        <table class="table table-responsive table-striped" id="datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>Sr#</th>
                                    <th>@lang('customer.customerName')</th>
                                    <th>@lang('customer.customerOldNumber')</th>
                                    <th>@lang('customer.customerNewNumber')</th>
                                    <th>@lang('customer.customerReason')</th>
                                    <th>@lang('customer.customerStatus')</th>
                                    <th>@lang('customer.customerRequestDate')</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th></th>
                                    <th></th>
                                    <th>@lang('customer.customerRequestDate')</th>
                                    <th>@lang('customer.customerStatus')</th>
                                    <th>@lang('customer.customerReason')</th>
                                    <th>@lang('customer.customerNewNumber')</th>
                                    <th>@lang('customer.customerOldNumber')</th>
                                    <th>@lang('customer.customerName')</th>
                                    <th>Sr#</th>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @foreach($requests as $reuest)
                                    @if($locale_array[$current_locale] == "English" )
                                        <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                                    <td>
                                        <strong>{{ !empty($reuest->relatedUser) ? (($reuest->relatedUser->first_name) ? $reuest->relatedUser->first_name . " " . $reuest->relatedUser->last_name : $reuest->relatedUser->name) : '-'  }}</strong>
                                    </td>
                                    <td>{{ $reuest->old_number }}</td>
                                    <td>{{ $reuest->new_number }}</td>
                                    <td>{{ $reuest->reason }}</td>
                                    <td>
                                    @if ($reuest->status === 'Pending')
                                   
                                    <div class="pending"> @lang('customer.pending')</div>
                                 
                                    @elseif   ($reuest->status === 'Approved')
                                 
                                    <span class="aprooved">@lang('customer.approved')</span>
                                    @else 
                                    <span class="cancel">@lang('customer.cancel')</span>
                                    @endif
                                    </td>
                                    <td>{{ date('Y-m-d h:i:s A', strtotime($reuest->created_at)) }}</td>
                                    <td>
                                        @if ($reuest->status === 'Pending')
                                        <a href="{{ route('change.requeststatus', ['id' => $reuest->id , 'status' => 'Approved']) }}"
                                            class="btn btn-success btn-sm" title="Approve">
                                            <i class="cil-check"></i>
                                        </a>
                                        @else
                                        <button class="btn btn-success btn-sm" title="Approve" disabled>
                                            <i class="cil-check"></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($reuest->status === 'Pending')
                                        <a href="{{ route('change.requeststatus', ['id' => $reuest->id , 'status' => 'Cancelled']) }}"
                                            class="btn btn-danger btn-sm" title="Cancel">
                                            <i class="cil-x"></i>
                                        </a>
                                        @else
                                        <button class="btn btn-danger btn-sm" title="Cancel" disabled>
                                            <i class="cil-x"></i>
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                    @else
                                        <tr class="align-right">
                                            <td>
                                                @if ($reuest->status === 'Pending')
                                                    <a href="{{ route('change.requeststatus', ['id' => $reuest->id , 'status' => 'Cancelled']) }}"
                                                       class="btn btn-danger btn-sm" title="Cancel">
                                                        <i class="cil-x"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-danger btn-sm" title="Cancel" disabled>
                                                        <i class="cil-x"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($reuest->status === 'Pending')
                                                    <a href="{{ route('change.requeststatus', ['id' => $reuest->id , 'status' => 'Approved']) }}"
                                                       class="btn btn-success btn-sm" title="Approve">
                                                        <i class="cil-check"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-success btn-sm" title="Approve" disabled>
                                                        <i class="cil-check"></i>
                                                    </button>
                                                @endif
                                            </td>
                                            <td>{{ date('Y-m-d h:i:s A', strtotime($reuest->created_at)) }}</td>
                                            <td>
                                                @if ($reuest->status === 'Pending')

                                                    <div class="pending"> @lang('customer.pending')</div>

                                                @elseif   ($reuest->status === 'Approved')

                                                    <span class="aprooved">@lang('customer.approved')</span>
                                                @else
                                                    <span class="cancel">@lang('customer.cancel')</span>
                                                @endif
                                            </td>
                                            <td>{{ $reuest->reason }}</td>
                                            <td>{{ $reuest->new_number }}</td>
                                            <td>{{ $reuest->old_number }}</td>
                                            <td>
                                                <strong>{{ !empty($reuest->relatedUser) ? (($reuest->relatedUser->first_name) ? $reuest->relatedUser->first_name . " " . $reuest->relatedUser->last_name : $reuest->relatedUser->name) : '-'  }}</strong>
                                            </td>
                                            <td><strong>{{ $i++ }}</strong></td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <!-- {{ $requests ?? ''->links() }} -->

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
    "pagingType": "full_numbers",
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[7,8 ]:[0,1] },
    ],
    "order": [[ 6, "desc" ]],
    language: {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
      
    }
})
</script>
@endsection
