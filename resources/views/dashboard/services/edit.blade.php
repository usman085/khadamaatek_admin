@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('service_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    @include('dashboard.websites.defaultRow')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('service.editServices')</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('service.update', $service->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('common.name')</label>
                                                <input class="form-control" type="text" placeholder="@lang('common.name')" name="name" required
                                                    autofocus value="{{ $service->name }}" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("group.logo")</label>
                                                <input class="form-control" type="file" placeholder="@lang('group.logo')"
                                                    name="logo" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("group.group")</label>
                                                <select name="group_id" id="group_id" class="form-control select2" required>
                                                    <option value="">@lang("group.chooseGroup")</option>
                                                    @foreach ($groups as $item)
                                                    <option value="{{ $item->id }}" data-departments='{{ $item->departments }}'
                                                        <?php if($item->id == $service->group_id) { echo 'selected'; } ?>>
                                                        {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("department.department")</label>
                                                <select name="department_id" id="department_id" class="form-control select2
                                                @if(count($categories) === 0)
                                                no-main-cat
                                                @endif
                                                "
                                                    required>
                                                    <!-- <option value="">@lang("department.chooseDepartment")</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        @foreach ($categories as $key => $cat_item)
                                        @if ($key === 0)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("service.serviceCategory")</label>
                                                <select name="category_id[]" id="category_id" class="form-control select2"
                                                    >
                                                    <option value="">@lang("service.chooseCategory")</option>
                                                    @foreach ($cat_item['data'] as $item)
                                                        @if($item->department_id != $service->department_id)
                                                            @continue
                                                        @endif
                                                        <option value="{{ $item->id }}"
                                                            @if($item->id == $cat_item['selected_id'])
                                                                selected
                                                            @endif
                                                            >
                                                                {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6 sub-category-col sub-category-col-{{$key}}"
                                            data-element_no="{{$key}}" required>
                                            <div class="form-group">
                                                <label>@lang("service.subCategory")</label>
                                                <select name="category_id[]" id="sub_category_id_{{$key}}"
                                                    class="form-control select2 subcat_select">
                                                    <option value="">@lang("service.chooseCategory")</option>
                                                    @foreach ($cat_item['data'] as $item)
                                                    <option value="{{ $item->id }}"
                                                        <?php if($item->id == $cat_item['selected_id']) { echo 'selected'; } ?>>
                                                        {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach

                                        @if(count($categories) === 0)
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group">
                                                    <label>@lang("service.serviceCategory")</label>
                                                    <select name="category_id[]" id="category_id" class="form-control select2">
                                                        <option value="">@lang("service.chooseCategory")</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6 d-none sub-category-col sub-category-col-1"
                                                data-element_no="1">
                                                <div class="form-group">
                                                    <label>@lang("service.subCategory")</label>
                                                    <select name="category_id[]" id="sub_category_id_1"
                                                        class="form-control select2 subcat_select">
                                                        <option value="">@lang("service.chooseCategory")</option>
                                                    </select>
                                                </div>
                                            </div>
                                        @endif

                                        @if (count($categories) === 1)
                                        <div class="col-md-6 d-none sub-category-col sub-category-col-1"
                                            data-element_no="1">
                                            <div class="form-group">
                                                <label>@lang("service.subCategory")</label>
                                                <select name="category_id[]" id="sub_category_id_1"
                                                    class="form-control select2 subcat_select">
                                                    <option value="">@lang("service.chooseCategory")</option>
                                                </select>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang("service.docTemplate")</label>
                                                <select name="formbuilder_id[]" multiple="multiple" id="formbuilder_id" class="form-control select2"
                                                    required>
                                                    @foreach ($forms as $form)
                                                    <option value="{{ $form->id }}" @if(in_array($form->id,$service->formbuilder_id)) selected @endif>
                                                        {{ $form->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>@lang("service.serviceFee")</label>
                                                <input class="form-control" type="number" placeholder="@lang('service.enterFee')" name="fee"
                                                    required value="{{ $service->fee }}" />
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-5 text-right">
                                    @if ($service->logo)
                                    <a href="{{ asset('images_logos\\') . $service->logo->name }}" target="_blank">
                                        <img src="{{ asset('images_logos\\') . $service->logo->name }}"
                                            class="img-fluid img-thumbnail" alt="{{ $service->logo->name }}"
                                            style="max-height: 400px;" />
                                        @endif
                                    </a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">@lang("service.serviceDetail")</label>
                                        <textarea name="service_detail" id="service_detail" class="form-control" rows="2">{{ $service->service_detail }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @include('dashboard.websites.edit', ['rows' => $service])


                                <div class="col-lg-6">
                                    <button class="btn btn-success" type="submit">@lang("common.edit")</button>
                                    <a href="{{ route('service.index') }}" class="btn btn-primary">@lang("common.back")</a>
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
                $('#sub_category_id_1').val('').removeAttr('required');
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
                    data.forEach(element => {
                        options += `<option value="${element.id}">${element.name}</option>`;
                    });
                }

                $('#category_id').html(options);
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

                    $('#sub_category_id_1').html(options).trigger('change');
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
                        `<div class="col-md-6 sub-category-col ${subcat_col_class}" data-element_no='${(total_subcats+1)}'>`;
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

    $('#group_id').on('change', function (e, select_dep = 0) {
        let option = '<option value="">@lang('department.chooseDepartment')</option>';
        let depts = $(this).find('option:selected').data('departments');
        if (depts) {
            depts.forEach(el => {
                if (select_dep == el.id) {
                    option += `<option value="${el.id}" selected>${el.name}</option>`;
                } else {
                    option += `<option value="${el.id}">${el.name}</option>`;
                }
            });
        }
        $('#department_id').html(option);
        if (!select_dep) {
            $('#department_id').trigger('change');
        }
    });

    $('#department_id').on('change', function (e) {
        var dept_id = $(this).val();
        $('#category_id').html('<option value="">Choose Category</option>');
        resetSubCats();
        if (dept_id) {
            getCats(dept_id);
        }
    });

    $('#category_id').on('change', function (e) {
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

    $('#group_id').trigger('change', {{ $service->department_id }});
    $(".no-main-cat").trigger('change');

    jQuery(document).ready(function () {
        setTimeout(function(){
            $('#formbuilder_id').select2({
                placeholder: "@lang('service.chooseDocument')"

            });
        },100);
    });

</script>
@endsection
