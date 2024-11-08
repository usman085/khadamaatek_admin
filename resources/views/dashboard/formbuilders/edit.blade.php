@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('template_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <table id="getTableRow" style="display: none">
        <tr>
            <td><input type='text' name='rows[][label]' placeholder='Label' class='form-control' required></td>
            <td>
                <select name='rows[][document]' class='form-control' required>
                    <option value="" selected disabled>Choose Document</option>
                    @foreach ($documents as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->name }}</option>
                    @endforeach
                </select>
            </td>
            <td class="text-center">
                <button class="btn btn-danger btnRemoveRow" type="button">
                    <i class="cil-trash"></i>
                </button>
            </td>
        </tr>
    </table>

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ __('Edit') }}: {{ $form->name }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('forms.update', $form->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col">
                                            <label>Title</label>
                                            <input class="form-control" type="text" placeholder="{{ __('Title') }}"
                                                name="title" value="{{ $form->name }}" required autofocus>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button class="btn btn-primary btnAddRow" type="button">+ Add Row</button>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-hover form-table">
                                        <thead>
                                            <tr>
                                                <th>Label</th>
                                                <th>Document</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($form->requirement_detail as $item)
                                            <tr>
                                                <td><input type='text' name='rows[][label]' placeholder='Label'
                                                        class='form-control' value="{{ $item->label }}"></td>
                                                <td>
                                                    <select name='rows[][document]' class='form-control' required>
                                                        <option value="" selected disabled>Choose Document</option>
                                                        @foreach ($documents as $doc)
                                                        <option value="{{ $doc->id }}" @if($item->document_id ==
                                                            $doc->id) {{ "selected" }}
                                                            @endif>{{ $doc->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-danger btnRemoveRow" type="button">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('forms.index') }}" class="btn btn-primary">{{ __('Back') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    function addRow(html) {
        $('.form-table tbody').append(html);
    }

    $('.btnAddRow').on('click', function (e) {
        addRow($('#getTableRow tbody').html());
    });

    $('.form-table').on('click', '.btnRemoveRow', function (e) {
        $(this).closest('tr').remove();
    });

</script>
@endsection
