@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('transactions') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
<style>
.chip {
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

.cancel {
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
    #transactions-table{
        width: 100% !important;
    }
</style>
@if($current_locale == "ar")
    <style>
        #transactions-table{
            text-align: right;
        }
    </style>
@endif
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header {{$current_locale == "en"? '':'align-right'}}">
                        @if($current_locale == "en")
                        <i class="fa fa-align-justify"></i> @lang('transaction.transactions')
                        @else
                            @lang('transaction.transactions') <i class="fa fa-align-justify"></i>
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
                        <div class="reponse-message d-none alert alert-success" role="alert"></div>

                        {{-- <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>From Acc/No</th>
                                    <th>From Account Title</th>
                                    <th>To Acc/No</th>
                                    <th>To Account Title</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th> --}}
                        {{-- <th></th> --}}
                        {{-- </tr>
                            </thead>
                            <tbody>
                                <?php // $i=1; ?>
                                @foreach($transactions as $transaction)
                                <?php 
                                    $from_type = $transaction->from_type;
                                    $from_name = "";
                                    $to_type = $transaction->to_type;
                                    $to_name = "";

                                    if($from_type == 'App\User') {
                                        $from_user = $transaction->from_user;
                                        $from_name = $transaction->from_user->name;
                                    } else {
                                        $from_user = $transaction->from_customer;
                                        $from_name = ($from_user) ? $from_user->first_name . " " . $from_user->last_name : "";
                                    }
                                    
                                    if($to_type == 'App\User') {
                                        $to_user = $transaction->to_user;
                                        $to_name = $transaction->to_user->name;
                                    } else {
                                        $to_user = $transaction->to_customer;
                                        $to_name = ($to_user) ? $to_user->first_name . " " . $to_user->last_name : "";
                                    }
                                ?>
                                <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                        <td><strong>{{ ($from_user) ? $from_user->account_no : "" }}</strong></td>
                        <td>{{ $from_name }}</td>
                        <td><strong>{{ ($to_user) ? $to_user->account_no : ""}}</strong>
                        </td>
                        <td>{{ $to_name }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <!-- <td>{{ $transaction->etype }}</td> -->
                        <td>
                            <span class="{{ $transaction->status }} text-uppercase">
                                <div class="chip">
                                    {{ $transaction->status }}
                            </span>
                        </td>
                        <td>
                            @if ($transaction->attachment)
                            <a href="/transactions/{{ $transaction->attachment }}" target="_blank"
                                class="btn btn-warning btn-sm">
                                <i class="cil-file"></i></a>
                            @else
                            <button class="btn btn-warning btn-sm"><i class="cil-file"></i></button>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('transaction.edit', $transaction->id ) }}"
                                class="btn btn-primary  btn-sm">
                                <i class="cil-pencil"></i></a>
                        </td>
                        @if (isset($delt)) --}}
                        {{-- <td>
                                        <form action="{{ route('transaction.destroy', $transaction->id ) }}"
                        onsubmit="return confirm('Are you sure to delete?')" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger  btn-sm">
                            <i class="cil-trash"></i>
                        </button>
                        </form>
                        </td> --}}
                        {{-- @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $transactions ?? ''->links() }} --}}
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
{{$dataTable->scripts()}}
<script>
    var element = document.getElementById("transactions-table");
    element.classList.add("table-responsive");
 </script>
@endsection