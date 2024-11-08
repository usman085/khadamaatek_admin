@extends('dashboard.base')

@section('breadcrumbs')
    {{ Breadcrumbs::render('documents') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
@section('css')
    <style>
        select[name="datatable_length"] {
            min-width: 60px;
        }
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
                        <i class="fa fa-align-justify"></i> @lang('document.docTemplates')
                        @else
                            @lang('document.docTemplates') <i class="fa fa-align-justify"></i>
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
                            <a href="{{ route('documents.create') }}" class="btn btn-primary m-2">@lang('document.addDocTemplates')</a>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped" id="datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th style="width: 70%">@lang('document.title')</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="width: 70%">@lang('document.title')</th>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                    @if($locale_array[$current_locale] == "English" )
                                        <tr>
                                    <td><strong>{{ $form->name }}</strong></td>
                                    <td>
                                        <a href="{{ route('documents.show', $form->id) }}"
                                            class="btn btn-block btn-primary">@lang('service.view')</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('documents.edit', $form->id) }}"
                                            class="btn btn-block btn-primary">@lang('common.edit')</a>
                                    </td>
                                    <td>
                                        <form class="form" action="{{ route('documents.destroy', $form->id ) }}" method="POST"
                                         >
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-block btn-danger">@lang('common.delete')</button>
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
                                                <form class="form" action="{{ route('documents.destroy', $form->id ) }}" method="POST"
                                                >
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-block btn-danger">@lang('common.delete')</button>
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
                                                <a href="{{ route('documents.edit', $form->id) }}"
                                                   class="btn btn-block btn-primary">@lang('common.edit')</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('documents.show', $form->id) }}"
                                                   class="btn btn-block btn-primary">@lang('service.view')</a>
                                            </td>
                                            <td><strong>{{ $form->name }}</strong></td>
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
        { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[1,2,3 ]:[0,1,2 ] },
],
    language: {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
      
    }
})
</script>
@endsection
