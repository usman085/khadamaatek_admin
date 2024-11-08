@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('group_add') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang("group.addGroup")</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('groups.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('common.name')</label>
                                        <input class="form-control" type="text" placeholder="@lang('common.name')" name="name" required
                                            autofocus />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang("group.logo")</label>
                                        <input class="form-control" type="file" placeholder="@lang('group.logo')" name="logo" />
                                    </div>
                                </div>

                                <div class="col-lg-12">

                                    <button class="btn btn-success" type="submit">@lang("common.save")</button>
                                    <a href="{{ route('groups.index') }}" class="btn btn-primary">@lang("common.back")</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
@endsection
