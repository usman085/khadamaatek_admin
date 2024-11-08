@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('role_add') }}
@endsection

@section('content')


<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header"><h4>@lang('setting.addRole')</h4></div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                @endif
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <table class="table table-bordered datatable">
                        <tbody>
                            <tr>
                                <th>
                                @lang('common.name') 
                                </th>
                                <td>
                                    <input class="form-control" name="name" type="text"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" type="submit">  @lang('common.save')</button>
                    <a class="btn btn-primary" href="{{ route('roles.index') }}">  @lang('common.back')</a>
                </form>
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