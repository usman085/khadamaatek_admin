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
            var $self = $(this);
            //if($self.closest('tbody').parent().children('tbody').length > 1){
                $self.closest('tbody').remove();
            //}else{
            //    alert("Sorry! Atleast one website detail required!");
            //}
        });
        addRow($('#getTableRow').html());
    }

</script>
