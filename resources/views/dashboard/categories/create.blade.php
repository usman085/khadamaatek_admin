@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('category_add') }}
@endsection

@section('content')

<div class="container-fluid">
    @include('dashboard.websites.defaultRow')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-6 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4> @lang('service.addServiceCategory')</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('common.name')</label>
                                        <input class="form-control" type="text" placeholder="@lang('common.name')" name="name" required
                                            autofocus />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang("group.logo")</label>
                                        <input class="form-control" type="file" placeholder="Logo" name="logo" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang("group.group")</label>
                                        <select name="group_id" id="group_id" class="form-control select2" required>
                                            <option value="">@lang('department.chooseGroup')</option>
                                            @foreach ($groups as $item)
                                            <option value="{{ $item->id }}" data-departments='{{ $item->departments }}'>
                                                {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('department.department')</label>
                                        <select name="department_id" id="department_id" class="form-control select2"
                                            required>
                                            <option value="">@lang('department.chooseDepartment')</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('service.parentCategory')</label>
                                        <select name="parent_id" id="parent_id" class="form-control select2">
                                            <option value="">@lang('service.chooseCategory')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-6 d-none sub-category-col sub-category-col-1"
                                    data-element_no="1">
                                    <div class="form-group">
                                        <label>@lang('service.subCategory')</label>
                                        <select name="category_id[]" id="sub_category_id_1"
                                            class="form-control select2 subcat_select">
                                            <option value="">@lang('service.chooseCategory')</option>
                                        </select>
                                    </div>
                                </div>


                                @include('dashboard.websites.form')

                                <div class="col-lg-6">

                                    <button class="btn btn-success" type="submit">@lang("common.save")</button>
                                    <a href="{{ route('category.index') }}" class="btn btn-primary">@lang("common.back")</a>
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

    function resetSubCats() {
        $('.sub-category-col').each(function (ind, el) {
            if ($(this).hasClass('sub-category-col-1')) {
                $(this).addClass('d-none');
                $('#sub_category_id_1').removeAttr('required');
            } else {
                $(this).remove();
            }
        });
    }

    function getCats(dep_id) {
        $.ajax({
            url: "{{ url('admin/department/get-categories/') }}" + "/" + dep_id,
            method: "GET",
            dataType: "JSON",
            success: function (data) {
                let options = '<option value="">Choose Category</option>';
                if (data) {
                    data.forEach(function (element, index) {
                        options += `<option value="${element.id}">${element.name}</option>`;
                    })
                    // data.forEach(element => {
                    // });
                }

                $('#parent_id').html(options);
            },
            error: function (xhr, error, errorData) {
                console.log(errorData);
            }

        })

    }

    function getSubCats(cat_id) {
        $.ajax({
            url: "{{ url('admin/service-category/get-sub-categories/') }}" + "/" + cat_id,
            method: "GET",
            dataType: "JSON",
            success: function (data) {
                if (data && data.length > 0) {
                    let options = '<option value="">Choose Category</option>';

                    data.forEach(element => {
                        options += `<option value="${element.id}">${element.name}</option>`;
                    });

                    $('#sub_category_id_1').html(options);
                    $('.sub-category-col-1').removeClass('d-none').fadeIn();
                }
            },
            error: function (xhr, error, errorData) {
                console.log(errorData);
            }

        })

    }

    function getSubCatsBySubCat(cat_id, parent_col) {
        $.ajax({
            url: "{{ url('admin/service-category/get-sub-categories/') }}" + "/" + cat_id,
            method: "GET",
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data && data.length > 0) {
                    let total_subcats = $('.sub-category-col').length;
                    let prevsubcatclass = '.sub-category-col-' + (total_subcats);
                    let subcat_col_class = 'sub-category-col-' + (total_subcats + 1);
                    let subcat_select_id = 'sub_category_id-' + (total_subcats + 1);

                    let html =
                        `<div class="col-lg-4 col-sm-6 sub-category-col ${subcat_col_class}" data-element_no='${(total_subcats+1)}'>`;
                    html += '<div class="form-group">';
                    html += '<label>Sub Category</label>';
                    html +=
                        `<select name="category_id[]" id="${subcat_select_id}" class="form-control subcat_select select2">`;
                    html += '<option value="">Choose Category</option>';

                    data.forEach(element => {
                        html += `<option value="${element.id}">${element.name}</option>`;
                    });
                    html += '</select>';
                    html += '</div>';
                    html += '</div>';

                    // $('#sub_category_id_1').html(options);
                    $(prevsubcatclass).after(html);
                    $('select.select2').each(function (ind, el) {
                        if (!$(this).hasClass("select2-hidden-accessible")) {
                            $(this).select2();
                        }
                    });
                }
            },
            error: function (xhr, error, errorData) {
                console.log(errorData);
            }

        })

    }

    $('#parent_id').on('change', function (e) {
        var cat_id = $(this).val();
        resetSubCats();
        if (cat_id) {
            getSubCats(cat_id);
        }
    });

    $('body').on('change', '.subcat_select', function (e) {
        var cat_id = $(this).val();
        let parent = $(this).parent().parent();
        $(parent).nextAll("div.sub-category-col").remove();
        if (cat_id) {
            getSubCatsBySubCat(cat_id, parent);
        }
    });

    $('#group_id').on('change', function (e) {

        let option = '<option value="">Choose Department</option>';
        let depts = $(this).find('option:selected').data('departments');
        if (depts) {
            depts.forEach(el => {
                option += `<option value="${el.id}">${el.name}</option>`;
            });
        }
        $('#department_id').html(option).trigger('change');
    });

    $('#department_id').on('change', function (e) {
        var dept_id = $(this).val();
        $('#parent_id').html('<option value="">Choose Category</option>');
        if (dept_id) {
            getCats(dept_id);
        }
    });

</script>
@endsection
