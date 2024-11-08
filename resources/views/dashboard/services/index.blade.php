@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('services') }}
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
                        <i class="fa fa-align-justify"></i> @lang('service.services')
                         @else
                            @lang('service.services') <i class="fa fa-align-justify"></i>
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
                            <a href="{{ route('service.create') }}" class="btn btn-primary m-2">
                            @lang('service.addNewService')
                           </a>
                        </div>
                        <br>
                        <table class="table table-responsive table-striped" id="datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>Sr#</th>
                                    <th>@lang("common.name")</th>
                                    <th>@lang("department.departments")</th>
                                    <th>@lang("service.mainCategory")</th>
                                    <th>@lang("service.requirementTemplete")</th>
                                    <th>@lang("service.serviceDetail")</th>
                                    <th>@lang("service.fee")</th>

                                    <th></th>
                                    <th></th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th></th>
                                    <th></th>
                                    <th>@lang("service.fee")</th>
                                    <th>@lang("service.serviceDetail")</th>
                                    <th>@lang("service.requirementTemplete")</th>
                                    <th>@lang("service.mainCategory")</th>
                                    <th>@lang("department.departments")</th>
                                    <th>@lang("common.name")</th>
                                    <th>Sr#</th>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                <?php $i=1; ?>

                                @foreach($services as $service)
                                    @if($locale_array[$current_locale] == "English" )
                                    <tr>
                              
                                    <td><strong>{{ $service->id}}</strong></td>
                                    <td><strong>{{ $service->name }}</strong></td>
                                    <td>
                                        <strong>
                                            @if($service->department)
                                            {{$service->department->name}}
                                            @else
                                            ---
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                            @if($service->category)
                                            {{$service->category->name}}
                                            @else
                                            ---
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>
                                        @if($service->formbuilder_id)
                                            @php
                                            $requirement_document_name = '';
                                            foreach(json_decode($service->formbuilder_id,true) as $document){
                                                $document_object = App\Document::find($document);
                                                $requirement_document_name .= "<span class='badge badge-info ml-1'>$document_object->name</span>";
                                            }
                                            echo $requirement_document_name 
                                            @endphp 
                                            
                                            @else
                                            ---
                                            @endif
                                        </strong>
                                    </td>
                                    <td>
                                        <strong>{{ $service->service_detail }}</strong>
                                    </td>
                                    <td><strong>{{ $service->fee }}</strong></td>
                                    <td>
                                        <a href="{{ url('/admin/service/' . $service->id . '/edit') }}"
                                            class="btn btn-primary">@lang('common.edit')</a>
                                    </td>
                                    <td>
                                        <form class="form" action="{{ route('service.destroy', $service->id ) }}"
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
                                                <form class="form" action="{{ route('service.destroy', $service->id ) }}"
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
                                                <a href="{{ url('/admin/service/' . $service->id . '/edit') }}"
                                                   class="btn btn-primary">@lang('common.edit')</a>
                                            </td>
                                            <td><strong>{{ $service->fee }}</strong></td>
                                            <td>
                                                <strong>{{ $service->service_detail }}</strong>
                                            </td>
                                            <td>
                                                <strong>
                                                    @if($service->formbuilder_id)
                                                        @php
                                                            $requirement_document_name = '';
                                                            foreach(json_decode($service->formbuilder_id,true) as $document){
                                                                $document_object = App\Document::find($document);
                                                                $requirement_document_name .= "<span class='badge badge-info ml-1'>$document_object->name</span>";
                                                            }
                                                            echo $requirement_document_name
                                                        @endphp

                                                    @else
                                                        ---
                                                    @endif
                                                </strong>
                                            </td>
                                            <td>
                                                <strong>
                                                    @if($service->category)
                                                        {{$service->category->name}}
                                                    @else
                                                        ---
                                                    @endif
                                                </strong>
                                            </td>
                                            <td>
                                                <strong>
                                                    @if($service->department)
                                                        {{$service->department->name}}
                                                    @else
                                                        ---
                                                    @endif
                                                </strong>
                                            </td>
                                            <td><strong>{{ $service->name }}</strong></td>
                                            <td><strong>{{ $service->id}}</strong></td>

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
        { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[7,8 ]:[0,1 ] },
    ],
    language: {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
      
    }
})
</script>
@endsection


