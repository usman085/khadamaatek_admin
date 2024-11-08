@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('categories') }}
@endsection

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
    @php
        $current_locale = Session::get('current_locale','en');
        $locale_array = ['en'=>'English','ar'=>'Arabic']
    @endphp
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header {{$current_locale == "en"? '':'align-right'}}">
                        @if($current_locale == "en")
                        <i class="fa fa-align-justify"></i> @lang('service.serviceCategory')
                        @else
                            @lang('service.serviceCategory') <i class="fa fa-align-justify"></i>
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
                            <a href="{{ route('category.create') }}" class="btn btn-primary m-2">
                            @lang('service.addServiceCategory')
                            </a>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped"  id="datatable">
                            <thead>
                            @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <th>Sr#</th>
                                    <th>@lang("common.name")</th>
                                    <th>@lang("department.departments")</th>
                                    <th>@lang("group.group")</th>
                                    <th>@lang("service.view")</th>
                                    <th>@lang("common.edit")</th>
                                    <th>@lang("common.delete")</th>
                                </tr>
                            @else
                                <tr class="align-right">
                                    <th>@lang("common.delete")</th>
                                    <th>@lang("common.edit")</th>
                                    <th>@lang("service.view")</th>
                                    <th>@lang("group.group")</th>
                                    <th>@lang("department.departments")</th>
                                    <th>@lang("common.name")</th>
                                    <th>Sr#</th>
                                </tr>
                            @endif
                            </thead>
                            <tbody>
                                @if($categories)
                                <?php $i=1; ?>
                                @foreach($categories as $category)

                                <!-- @php
                                  echo gettype($category)
                                @endphp -->
                                @if($locale_array[$current_locale] == "English" )
                                <tr>
                                    <td><strong>{{ $category->id }}</strong></td>
                                    <td>
                                    <strong>{{$category->name}}</strong>
                                    </td>
                                    <td>
                                    <strong>
                                            @if($category->department)
                                            {{$category->department->name}}
                                            @else
                                            ---
                                            @endif
                                    </strong>
                                    </td>
                                    <td>
                                    <strong>
                                            @if($category->department)
                                            @if($category->department->group)
                                            
                                            {{$category->department->group->name}}
                                            @else
                                            ---
                                            @endif
                                            @else
                                            ---
                                            @endif
                                    </strong>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/service-category/view-child/' . $category->id) }}"
                                            class="btn btn-primary">@lang("service.viewChild")</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/service-category/' . $category->id . '/edit') }}"
                                            class="btn btn-primary">@lang("common.edit")</a>
                                    </td>
                                    <td>
                                        <form class="form" action="{{ route('category.destroy', $category->id ) }}"
                                           
                                             method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">@lang("common.delete")</button>
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
                                    <tr  class="align-right">
                                        <td>
                                            <form class="form" action="{{ route('category.destroy', $category->id ) }}"

                                                  method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger">@lang("common.delete")</button>
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
                                            <a href="{{ url('/admin/service-category/' . $category->id . '/edit') }}"
                                               class="btn btn-primary">@lang("common.edit")</a>
                                        </td>
                                        <td>
                                            <a href="{{ url('/admin/service-category/view-child/' . $category->id) }}"
                                               class="btn btn-primary">@lang("service.viewChild")</a>
                                        </td>
                                        <td>
                                            <strong>
                                                @if($category->department)
                                                    @if($category->department->group)

                                                        {{$category->department->group->name}}
                                                    @else
                                                        ---
                                                    @endif
                                                @else
                                                    ---
                                                @endif
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>
                                                @if($category->department)
                                                    {{$category->department->name}}
                                                @else
                                                    ---
                                                @endif
                                            </strong>
                                        </td>
                                        <td>
                                            <strong>{{$category->name}}</strong>
                                        </td>
                                        <td><strong>{{ $category->id }}</strong></td>
                                    </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- {{ $categories ?? ''->links() }} -->
                        <div id="data">
                          
                        </div>
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
        { "bSortable": false, "aTargets": "{{$current_locale}}"=='en'?[4, 5, 6 ]:[0, 1, 2 ] },
    ],
    language: {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/@lang('common.lang').json"
      
    }
});
</script>

@endsection