@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('user_add') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> @lang('setting.addUser')</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">@lang('common.name')</label>
                                        <input class="form-control" type="text" placeholder="@lang('common.name')"
                                            name="name" required autofocus>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="email">@lang('setting.email')</label>
                                        <input class="form-control" type="text" placeholder="@lang('setting.email')"
                                            name="email" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="phone_no">@lang('setting.phoneNo')</label>
                                        <input class="form-control" type="text" placeholder="@lang('setting.phoneNo')"
                                            name="phone_no" required>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">@lang('setting.user') @lang('setting.roles'): </label><br>
                                        @foreach($roles as $role)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="role[]" value="{{ $role }}"
                                                class="form-check-input" />
                                            <label class="form-check-label" for="inlineCheckbox1">{{ $role }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="name">@lang('document.password')</label>
                                        <input class="form-control" type="password" placeholder="@lang('document.password')"
                                            name="password" required>
                                    </div>

                                    <button class="btn btn-block btn-success" type="submit">@lang('common.save')</button>
                                    <a href="{{ route('users.index') }}"
                                        class="btn btn-block btn-primary">@lang('common.back')</a>
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
