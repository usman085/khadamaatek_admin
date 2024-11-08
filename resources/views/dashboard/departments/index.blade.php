@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('departments') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp

@section('css')
    <style>
        #departments-table{
            width: 100% !important;
        }
    </style>
    @if($locale_array[$current_locale] == "Arabic" )
    <style>
        #departments-table{
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
                        <i class="fa fa-align-justify"></i> @lang('department.departments')
                        @else
                            @lang('department.departments')  <i class="fa fa-align-justify"></i>
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
                            <a href="{{ route('department.create') }}" class="btn btn-primary m-2">
                            @lang('department.addDepartment')
                           </a>
                        </div>
                        {{-- <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php // $i=1; ?>
                                @foreach($departments as $dept)
                                <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                        <td><strong>{{ $dept->name }}</strong></td>
                        <td><strong>{{ $dept->group['name'] }}</strong></td>
                        <td>
                            <a href="{{ url('/admin/department/' . $dept->id . '/edit') }}"
                                class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form class="form"  action="{{ route('department.destroy', $dept->id ) }}"
                               method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger">Delete</button>
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
                        @endforeach
                        </tbody>
                        </table>
                        {{ $departments ?? ''->links() }} --}}
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
