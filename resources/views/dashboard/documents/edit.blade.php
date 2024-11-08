@extends('dashboard.base')

@push('custome_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('breadcrumbs')
{{ Breadcrumbs::render('document_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <table id="getTableRow" style="display: none">
        <tr>
            <td><input type='text' name='rows[][label]' placeholder="@lang('document.label')" class='form-control'></td>
            <td>
                <select name='rows[][type]' class='form-control'>
                    <option value="text">@lang('document.text')</option>
                    <option value="number">@lang('document.number')</option>
                    <option value="password">@lang('document.password')</option>
                    <option value="file">@lang('document.file')</option>
                    <option value="date">@lang('document.date')</option>
                    <option value="hidden">@lang('document.hidden')</option>
                </select>
            </td>
            <td><input type='text' name='rows[][placeholder]' placeholder="@lang('document.placeholder')" class='form-control'></td>
            <td>
                <select name='rows[][required]' class='form-control'>
                    <option value="false">@lang('document.no')</option>
                    <option value="true">@lang('document.yes')</option>
                </select>
            </td>
            <td>
                <select name='rows[][readonly]' class='form-control'>
                    <option value="false">@lang('document.no')</option>
                    <option value="true">@lang('document.yes')</option>
                </select>
            </td>
            <td>
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
                        <i class="fa fa-align-justify"></i> @lang('common.edit') : {{ $form->name }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('documents.update', $form->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="col">
                                            <label>@lang('document.title')</label>
                                            <input class="form-control" type="text" placeholder="@lang('document.readonly')"
                                                name="title" value="{{ $form->name }}" required autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('document.docType')</label>
                                        <input class="form-control" value="{{ $form->document_type }}" id="document_type_auto_complete" type="text" placeholder="@lang('document.docType')"
                                            name="document_type" required autofocus>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button class="btn btn-primary btnAddRow" type="button">+ @lang('department.addRow')</button>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-hover form-table">
                                        <thead>
                                            <tr>
                                                <th>@lang('document.label')</th>
                                                <th>@lang('document.inputType')</th>
                                                <th>@lang('document.placeholder')</th>
                                                <th>@lang('document.required')</th>
                                                <th>@lang('document.readonly')</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (json_decode($form->schema) as $item)
                                            <tr>
                                                <td><input type='text' name='rows[][label]' placeholder="@lang('document.label')"
                                                        class='form-control' value="{{ $item->label }}"></td>
                                                <td>
                                                    <select name='rows[][type]' class='form-control'>
                                                        <option value="text" @if(isset($item->inputType) &&
                                                            $item->inputType == 'text') {{ "selected" }}
                                                            @endif>@lang('document.text')</option>
                                                        <option value="number" @if(isset($item->inputType) &&
                                                            $item->inputType == 'number')
                                                            {{ "selected" }} @endif>@lang('document.number')</option>
                                                        <option value="file" @if($item->type == 'upload')
                                                            {{ "selected" }} @endif>@lang('document.file')</option>
                                                        <option value="date" @if(isset($item->inputType) &&
                                                            $item->inputType == 'date') {{ "selected" }}
                                                            @endif>@lang('document.date')</option>
                                                        <option value="hidden" @if(isset($item->inputType) &&
                                                            $item->inputType == 'hidden')
                                                            {{ "selected" }} @endif>@lang('document.hidden')</option>
                                                    </select>
                                                </td>
                                                <td><input type='text' name='rows[][placeholder]'
                                                        placeholder="@lang('document.placeholder')" class='form-control'
                                                        value="{{ ($item->placeholder) ? $item->placeholder: "" }}">
                                                </td>
                                                <td>
                                                    <select name='rows[][required]' class='form-control'>
                                                        <option value="false" @if($item->required == 'false')
                                                            {{ 'selected' }} @endif>@lang('document.no')</option>
                                                        <option value="true" @if($item->required == 'true')
                                                            {{ 'selected' }} @endif>@lang('document.yes')</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name='rows[][readonly]' class='form-control'>
                                                        <option value="false" @if(isset($item->readonly) &&
                                                            $item->readonly == 'false')
                                                            {{ 'selected' }} @endif>@lang('document.no')</option>
                                                        <option value="true" @if(isset($item->readonly) &&
                                                            $item->readonly == 'true')
                                                            {{ 'selected' }} @endif>@lang('document.yes')</option>
                                                    </select>
                                                </td>
                                                <td>
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

                            <button class="btn btn-success" type="submit">@lang('common.save')</button>
                            <a href="{{ route('documents.index') }}" class="btn btn-primary">@lang('common.back')</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    (function () {
        $('#document_type_auto_complete').autocomplete({
            source: {!! $documents !!}
        });
    })();
    function addRow(html) {
        $('.form-table').append(html);
    }

    $('.btnAddRow').on('click', function (e) {
        addRow($('#getTableRow').html());
    });

    $('.form-table').on('click', '.btnRemoveRow', function (e) {
        $(this).closest('tr').remove();
    });

</script>
@endsection
