@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('category_child') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('service.serviceCategory'): {{ $category->name }}</h4>
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
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>@lang('service.childCategory')</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @foreach($category->subcategories as $item)
                                <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                                    <td><strong>{{ $item->name }}</strong></td>
                                    <td>
                                        <a href="{{ route('category.childs', ['id' => $item->id]) }}"
                                            class="btn btn-primary">@lang("service.viewChild")</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('category.edit', ['id' => $item->id ]) }}"
                                            class="btn btn-primary">@lang("common.edit")</a>
                                    </td>
                                    <td>
                                        <form class="form" action="{{ route('category.destroy', $item->id ) }}"
                                            onsubmit="return confirm('Are you sure to delete?')" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">@lang("common.delete")</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="javascript:void(0)" onclick="goBack()" class="btn btn-primary">@lang('service.returnMain')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
    <script>
        function goBack() {
        window.history.back();
        }
    </script>
@endsection
