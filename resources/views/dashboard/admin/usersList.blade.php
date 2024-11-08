@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('users') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp

@section('css')
    <style>
        #usersdatatable-table{
            width: 100% !important;
        }
    </style>
    @if($locale_array[$current_locale] == "Arabic" )
    <style>
        #usersdatatable-table{
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
                        <i class="fa fa-align-justify"></i> @lang('setting.user')
                        @else
                            @lang('setting.user') <i class="fa fa-align-justify"></i>
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
                        <div class="col-lg-12 {{$current_locale == "en"? '':'align-right'}}">
                            <a href="{{ route('users.create') }}" class="btn btn-primary m-2">@lang('setting.addUser')</a>
                        </div>
                        {{-- <br>
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('setting.username')</th>
                                    <th>@lang('setting.email')</th>
                                    <th>@lang('setting.phoneNo')</th>
                                    <th>@lang('setting.roles')</th>
                                    <th>@lang('setting.emailVerified')</th>
                                    {{-- <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_no }}</td>
                                    <td>{{ $user->menuroles }}</td>
                                    <td>{{ ($user->email_verified_at) ? "Verified" : "Not Verified" }}</td>
                                    {{-- <td>
                                        <a href="{{ url('/users/' . $user->id) }}"
                                    class="btn btn-block btn-primary">@lang('service.view')</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/users/' . $user->id . '/edit') }}"
                                            class="btn btn-block btn-primary">@lang('common.edit')</a>
                                    </td>
                                    <td>
                                        @if( $you->id !== $user->id )
                                        <form class="form" action="{{ route('users.destroy', $user->id ) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-block btn-danger"
                                                onclick="return confirm('Are you sure to delete?')">@lang('common.delete') @lang('setting.user')</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
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
@endsection
