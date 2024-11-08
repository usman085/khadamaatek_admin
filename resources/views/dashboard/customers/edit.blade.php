@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('customer_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('customer.editCustomer')</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('customer.firstName')</label>
                                        <input class="form-control"  onkeypress="return /[a-z]/i.test(event.key)"  type="text" placeholder="@lang('customer.firstName')"
                                            name="first_name" value="{{ $customer->first_name }}" required autofocus />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('customer.lastName')</label>
                                        <input class="form-control"  onkeypress="return /[a-z]/i.test(event.key)"  type="text" placeholder="@lang('customer.lastName')" name="last_name"
                                            value="{{ $customer->last_name }}" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>@lang('customer.email')</label>
                                        <input class="form-control" type="email" placeholder="@lang('customer.email')"
                                            value="{{ $customer->email }}" name="email" />
                                    </div>
                                </div>
                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <label>@lang('customer.CNIC')</label>
                                        <input class="form-control" type="number" placeholder="@lang('customer.CNIC')"
                                            value="{{ $customer->cnic }}" name="cnic" required />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-4">

                                    <div class="form-group">
                                        <label>@lang('customer.nationality')</label>
                                        <input class="form-control" onkeypress="return /[a-z]/i.test(event.key)" type="text"  placeholder="@lang('customer.nationality')"
                                            value="{{ $customer->nationality }}" name="nationality" required />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>@lang('customer.gender')</label>
                                        <select name="gender" id="gender" class="form-control" required>
                                            <option value="" selected disabled>@lang('customer.chooseGender')</option>
                                            <option value="Male" @if ($customer->gender == 'Male')
                                                {{ "selected" }}
                                                @endif>@lang('customer.Male')</option>
                                            <option value="Female" @if ($customer->gender == 'Female')
                                                {{ "selected" }}
                                                @endif>@lang('customer.Female')</option>
                                            <option value="Other" @if ($customer->gender == 'Other')
                                                {{ "selected" }}
                                                @endif>@lang('customer.Other')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>@lang('customer.phone_no')</label>
                                        <input class="form-control" type="number" placeholder="923XXXXXXXX"
                                            name="phone_no" value="{{ $customer->phone_no }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>@lang('customer.address')</label>
                                        <input class="form-control" type="text" placeholder="@lang('customer.address')" name="address"
                                            value="{{ $customer->address }}" />
                                    </div>

                                    <button class="btn btn-success" type="submit">@lang('common.edit')</button>
                                    <a href="{{ route('customers.index') }}" class="btn btn-primary">@lang('common.back')</a>
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
    function getSubCats(cat_id, selctedSubCat = "") {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('service-category/get-sub-categories/') }}" + "/" + cat_id,
            method: "GET",
            dataType: "JSON",
            success: function (data) {
                let options = '<option value="">Choose Category</option>';

                if (data) {
                    data.forEach(element => {
                        if (selctedSubCat == element.id) {
                            options +=
                                `<option value="${element.id}" selected="selected">${element.name}</option>`;
                        } else {
                            options += `<option value="${element.id}">${element.name}</option>`;
                        }
                    });
                }

                $('#sub_category_id').html(options);
            },
            error: function (xhr, error, errorData) {
                console.log(errorData);
            }

        })

    }

    $('#category_id').on('change', function (e) {
        var cat_id = $(this).val();
        getSubCats(cat_id);
    });

    getSubCats({
        {
            $order - > category_id
        }
    }, {
        {
            $order - > sub_category_id
        }
    })

</script>
@endsection
