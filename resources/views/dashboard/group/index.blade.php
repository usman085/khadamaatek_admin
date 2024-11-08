@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('groups') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp

@section('css')
    <style>
        #groups-table{
            width: 100% !important;
        }
    </style>
    @if($locale_array[$current_locale] == "Arabic" )
        <style>
            #groups-table{
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
                        <i class="fa fa-align-justify"></i> @lang('group.group')
                        @else
                            @lang('group.group')  <i class="fa fa-align-justify"></i>
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
                            <a href="{{ route('groups.create') }}" class="btn btn-primary m-2">
                            @lang('group.addNewGroup') </a>
                        </div>
                        {{-- <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th> @lang('common.name')</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead> --}}
                            {{-- <tbody>
                                <?php // $i=1; ?>
                                @foreach($groups as $item)
                                <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td>
                                <a href="{{ url('/admin/groups/' . $item->id . '/edit') }}"
                                    class="btn btn-primary">Edit</a>
                            </td>
                            <td>
                                <form class="form" action="{{ route('groups.destroy', $item->id ) }}"
                                    onsubmit="return confirm('Are you sure to delete?')" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                            </tbody> --}}
                        {{-- </table> --}}
                        {{-- {{ $groups ?? ''->links() }} --}}
                        {{ $dataTable->table() }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
<script>


</script>
{{$dataTable->scripts()}}
@endsection
