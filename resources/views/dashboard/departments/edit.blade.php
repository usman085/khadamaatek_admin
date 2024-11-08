@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('department_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <table id="getTableRow" style="display: none">
        <tr>
            <td><input type='text' name='rows[][website_name]' placeholder='@lang("department.websiteName")'
                    class='form-control english-char' required></td>
            <td><input type='text' name='rows[][website_url]' placeholder='@lang("department.websiteURL"):e.g. http://google.com'
                    class='form-control english-char' required></td>
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
                        <h4>@lang('department.editDepartment')</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('department.update', $department->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>@lang("common.name")</label>
                                                <input class="form-control" type="text" placeholder="@lang('common.name')" name="name"
                                                    required autofocus value="{{ $department->name }}" />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>@lang("group.logo")</label>
                                                <input class="form-control" type="file" placeholder="@lang('group.logo')"
                                                    name="logo" />
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>@lang("group.group")</label>
                                                <select name="group_id" id="group_id" class="form-control select2"
                                                    required>
                                                    <option value="">@lang('department.chooseGroup')</option>
                                                    @foreach ($groups as $item)
                                                    <option value="{{ $item->id }}"
                                                        <?php if($item->id == $department->group_id) { echo 'selected'; } ?>>
                                                        {{ $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-lg-6 text-right">
                                    @if ($department->logo)
                                    <a href="{{ asset('images_logos\\') . $department->logo->name }}" target="_blank">
                                        <img src="{{ asset('images_logos\\') . $department->logo->name }}"
                                            class="img-fluid img-thumbnail" alt="{{ $department->logo->name }}"
                                            style="max-height: 300px;" />
                                    </a>
                                    @endif
                                    <div style="margin-top:10px;"></div>
                                </div>
                            </div>

                            <div class="row">
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
                                                <th>@lang("department.websiteName")</th>
                                                <th>@lang("department.websiteURL")</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($department->websites as $website)
                                            <tr>
                                                <td><input type='text' name='rows[][website_name]'
                                                        placeholder='@lang("department.websiteName")' class='form-control english-char'
                                                        value="{{ $website->website_name }}" required></td>
                                                <td><input type='text' name='rows[][website_url]'
                                                        placeholder='@lang("department.websiteURL"):e.g. http://google.com'
                                                        class='form-control english-char'
                                                        value="{{ $website->website_url }}" required></td>
                                                <td>
                                                    <button class="btn btn-danger btnRemoveRow" type="button">
                                                        <i class="cil-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <button class="btn btn-success" type="submit">@lang("common.save")</button>
                                    <a href="{{ route('department.index') }}" class="btn btn-primary">@lang("common.back")</a>
                                </div>
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
<script>
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
