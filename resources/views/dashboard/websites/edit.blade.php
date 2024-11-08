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
            @foreach ($rows->websites as $website)
            <tr>
                <td><input type='text' name='rows[][website_name]' placeholder='@lang("department.websiteName")'
                        class='form-control english-char' value="{{ $website->website_name }}" required></td>
                <td><input type='text' name='rows[][website_url]' placeholder='@lang("department.websiteURL"):e.g. http://google.com'
                        class='form-control english-char' value="{{ $website->website_url }}" required></td>
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

<script>
    function addRow(html) {
        $('.form-table').append(html);
    }

    window.onload = () => {

        $('.btnAddRow').on('click', function (e) {
            addRow($('#getTableRow').html());
        });

        $('.form-table').on('click', '.btnRemoveRow', function (e) {
            $(this).closest('tr').remove();
        });

    }

</script>
