@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('template_show') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Requirement Template</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4>Title : {{ $form->name }}</h4>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-hover form-table">
                                            <thead>
                                                <tr>
                                                    <th>Label</th>
                                                    <th>Document</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($form->requirement_detail as $item)
                                                <tr>
                                                    <td>{{ $item->label }}</td>
                                                    <td>{{ $item->document->name }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <a href="{{ route('forms.index') }}" class="btn btn-primary">{{ __('Back') }}</a>
                            </div>
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
