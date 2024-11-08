@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('user_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-10 col-lg-6 col-xl-5">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>@lang('common.edit') : {{ $user->name }}</div>
                    <div class="card-body">
                        <br>
                        <form method="POST" action="/admin/users/{{ $user->id }}">
                            @csrf
                            @method('PUT')
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <svg class="c-icon c-icon-sm">
                                            <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                        </svg>
                                    </span>
                                </div>
                                <input class="form-control" type="text" placeholder="@lang('common.name')" name="name"
                                    value="{{ $user->name }}" required autofocus>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input class="form-control" type="text" placeholder="@lang('setting.emailAddress')"
                                    name="email" value="{{ $user->email }}" required>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">#</span>
                                </div>
                                <input class="form-control" type="text" placeholder="@lang('setting.phoneNo')"
                                    name="phone_no" value="{{ $user->phone_no }}" required>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="name">@lang('setting.user') @lang('setting.roles'): </label><br>
                                    @foreach($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="role[]" id="{{$role}}" value="{{ $role }}"
                                            class="form-check-input"
                                            @if (preg_match("/{$role}/i", $user->menuroles))
                                                {{ 'checked' }}                                                
                                            @endif
                                            />
                                        <label class="form-check-label" for="{{$role}}">{{ $role }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <button class="btn btn-block btn-success" type="submit">@lang('common.save')</button>
                            <a href="{{ route('users.index') }}"
                                class="btn btn-block btn-primary">@lang('common.back')</a>
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
