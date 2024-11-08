@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('templates') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ __('Requirement Template') }}</div>
                    <div class="card-body">
                        @if(Session::has('message'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <a href="{{ route('forms.create') }}"
                                class="btn btn-primary m-2">{{ __('Add Requirement Template') }}</a>
                        </div>
                        <br>
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 70%">Title</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                <tr>
                                    <td><strong>{{ $form->name }}</strong></td>
                                    <td>
                                        <a href="{{ route('forms.show', $form->id) }}"
                                            class="btn btn-block btn-primary">View</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('forms.edit', $form->id) }}"
                                            class="btn btn-block btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('forms.destroy', $form->id ) }}" method="POST"
                                            onsubmit="return confirm('Are you sure to delete?')">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-block btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $forms ?? ''->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')

@endsection
