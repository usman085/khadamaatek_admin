@extends('dashboard.base')

@push('custome_css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('breadcrumbs')
{{ Breadcrumbs::render('document_add') }}
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
                        <i class="fa fa-align-justify"></i>@lang('document.createDocTemp')</div>
                    <div class="card-body">
                        <form method="POST" autocomplete="off" action="{{ route('documents.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('document.title')</label>
                                        <input class="form-control" type="text" placeholder="@lang('document.title')"
                                            name="title" required autofocus>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('document.docType')</label>
                                        <input class="form-control" id="document_type_auto_complete" type="text" placeholder="@lang('document.docType')"
                                            name="document_type" required autofocus>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12 text-right">
                                            <button class="btn btn-primary btnAddRow" type="button">+  @lang('department.addRow')</button>
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
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12">
                                    <button class="btn btn-success" type="submit">@lang('common.save')</button>
                                    <a href="{{ route('documents.index') }}" class="btn btn-primary">@lang('common.back')</a>
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    (function () {
        addRow($('#getTableRow tbody').html());
        $('#document_type_auto_complete').autocomplete({
            source: {!! $documents !!}
        });
    })();

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
