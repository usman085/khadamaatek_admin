@extends('dashboard.base')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Service Category: {{ $category->name }}</h4>
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
                                    <th>Child Categories</th>
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
                                        <a href="{{ url('/service-category/view-child/' . $item->id) }}"
                                            class="btn btn-primary">View Childs</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('/service-category/' . $item->id . '/edit') }}"
                                            class="btn btn-primary">Edit</a>
                                    </td>
                                    <td>
                                        <form class="form" action="{{ route('category.destroy', $item->id ) }}"
                                            onsubmit="return confirm('Are you sure to delete?')" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">Delete</button>
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
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')

@endsection
