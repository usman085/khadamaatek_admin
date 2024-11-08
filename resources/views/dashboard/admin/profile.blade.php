@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('profile') }}
@endsection

@section('content')

<div class="container-fluid">
    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-6 col-md-5 col-lg-4 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="avatar-box">
                            <img class="c-avatar-img p-4"

                                src="{{ env('APP_URL', '') }}/assets/img/avatars/{{ auth()->user()->avatar }}"
                                alt="{{ auth()->user()->name }}"
                                style="max-height: 260px; margin: 0 auto; display: block;">
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-borderless table-responsive">
                                    <tr>
                                        <th>@lang('common.name'): </th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('setting.phoneNo')</th>
                                        <td>{{ $user->phone_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('setting.email'): </th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>@lang('setting.emailVerified'): </th>
                                        <td>
                                            @if ($user->email_verified_at)
                                            <span class="badge badge-success p-2">
                                                <span class="cil-check-alt"></span> @lang('setting.verified')
                                            </span>
                                            @else
                                            <span class="badge badge-danger verifyNow p-2" style="cursor:pointer;">
                                                <span class="cil-x"></span> @lang('setting.verifyNow')
                                                <span class="fa fa-spinner fa-spin d-none"></span>
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-5 col-lg-4 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill"
                                    href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="true">@lang('sideBar.Profile')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-bank-tab" data-toggle="pill" href="#pills-bank" role="tab"
                                    aria-controls="pills-bank" aria-selected="false">@lang('setting.bankAccountDetail')</a>
                            </li>
                        </ul>
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
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <form method="POST" action="{{ route('user.updateprofile') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">@</span>
                                        </div>
                                        <input class="form-control" type="text" placeholder="@lang('setting.email')"
                                            name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="cil-lock-locked"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="password" onpaste="return false" ondrop="return false"
                                            placeholder="@lang('setting.oldPassword')" name="old_password"
                                            >
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="cil-lock-locked"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="password" onpaste="return false" ondrop="return false"
                                            placeholder="@lang('setting.newPassword')" name="new_password">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="cil-image1"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" type="file" name="image"
                                            placeholder="Upload Profile Picture">
                                    </div>
                                    <button class="btn btn-success" type="submit">@lang('setting.update')</button>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="pills-bank" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <form method="POST" action="{{ route('user.updatebankdetail') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <?php $userBank = auth()->user()->bank; ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-gorup">
                                                <label for="bank_name">@lang('setting.bankName')</label>
                                                <input type="text" id="bank_name" name="bank_name" class="form-control"
                                                    value="{{ ($userBank) ? $userBank->bank_name: "" }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-gorup">
                                                <label for="account_title">@lang('setting.accountTitle')</label>
                                                <input type="text" id="account_title" name="account_title"
                                                    class="form-control"
                                                    value="{{ ($userBank) ? $userBank->account_title: "" }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="form-gorup">
                                                <label for="account_no">@lang('setting.bankAccount')</label>
                                                <input type="text" id="account_no" name="account_no"
                                                    class="form-control"
                                                    value="{{ ($userBank) ? $userBank->account_no: "" }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-gorup">
                                                <label for="sort_code">@lang('setting.sortCode')</label>
                                                <input type="text" id="sort_code" name="sort_code" class="form-control"
                                                    value="{{ ($userBank) ? $userBank->sort_code: "" }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="form-gorup">
                                                <label for="iban_no">IBAN</label>
                                                <input type="text" id="iban_no" name="iban_no" class="form-control"
                                                    value="{{ ($userBank) ? $userBank->iban_no: "" }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" type="submit">@lang('common.save')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    $('body').on('click', '.verifyNow', function (e) {
        const user_id = $('#user_id').val();
        if (user_id) {
            $('.fa-spin').removeClass('d-none');
            $.ajax({
                url: `/customer/email-verify-send/${user_id}`,
                data: {
                    user_type: 'admin'
                },
                dataType: 'JSON',
                type: "POST",
                success: function (reponse) {
                    // console.log(reponse);
                    $('.fa-spin').addClass('d-none');
                    alert(reponse.message);
                },
                error(error) {
                    $('.fa-spin').addClass('d-none');
                    alert("Email sending failed!!!");
                    console.log(error);
                }
            })
        } else {
            alert('User Missing!!');
        }
    });

</script>
@endsection
