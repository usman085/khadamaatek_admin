@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('roles') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
@section('content')


<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="{{$current_locale == "en"? '':'align-right'}}">@lang('setting.menuRoles')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 {{$current_locale == "en"? '':'align-right'}}">
                                <a class="btn btn-primary" href="{{ route('roles.create') }}">@lang('setting.addNewRole')</a>
                            </div>
                        </div>
                        <br>
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>@lang('common.name')</th>
                                    {{-- <th>Hierarchy</th> --}}
                                    <th>@lang('order.created_at')</th>
                                    <th>@lang('setting.updatedAt')</th>
                                    {{-- <th></th> --}}
                                    {{-- <th></th> --}}
                                    <th></th>
                                    {{-- <th></th> --}}
                                    <th></th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th></th>
                                    <th></th>
                                    <th>@lang('setting.updatedAt')</th>
                                    <th>@lang('order.created_at')</th>
                                    <th>@lang('common.name')</th>

                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                    @if($locale_array[$current_locale] == "English" )
                                        <tr>
                                    <td>
                                        {{ $role->name }}
                                    </td>
                                    {{-- <td>
                                    {{ $role->hierarchy }}
                                    </td> --}}
                                    <td>
                                        {{ $role->created_at }}
                                    </td>
                                    <td>
                                        {{ $role->updated_at }}
                                    </td>
                                    {{-- <td>
                                    <a class="btn btn-success" href="{{ route('roles.up', ['id' => $role->id]) }}">
                                    <i class="cil-arrow-thick-top"></i>
                                    </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-success"
                                            href="{{ route('roles.down', ['id' => $role->id]) }}">
                                            <i class="cil-arrow-thick-bottom"></i>
                                        </a>
                                    </td> --}}
                                    {{-- <td>
                                        <a href="{{ route('roles.show', $role->id ) }}" class="btn btn-primary">Show</a>
                                    </td> --}}
                                    <td class="text-center">
                                        <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-primary">@lang('common.edit')</a>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('roles.destroy', $role->id ) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">@lang('common.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                                    @else
                                        <tr class="align-right">
                                            <td class="text-center">
                                                <form action="{{ route('roles.destroy', $role->id ) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger">@lang('common.delete')</button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('roles.edit', $role->id ) }}" class="btn btn-primary">@lang('common.edit')</a>
                                            </td>
                                            <td>
                                                {{ $role->updated_at }}
                                            </td>
                                            <td>
                                                {{ $role->created_at }}
                                            </td>
                                            <td>
                                                {{ $role->name }}
                                            </td>
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
</div>

@endsection

@section('javascript')

@endsection
