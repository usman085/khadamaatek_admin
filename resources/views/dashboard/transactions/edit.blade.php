@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('transaction_edit') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang('transaction.editTransaction')</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('transaction.update', $transaction->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>@lang('order.fromAcc')</label>
                                        <input class="form-control" type="text" name="from_account_no"
                                            value="{{ $transaction->from_acc_id }}" disabled />
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('order.toAcc')</label>
                                        <input class="form-control" type="text" name="to_account_no"
                                            value="{{ $transaction->to_acc_id }}" disabled />
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('order.ammount')</label>
                                        <input type="text" name="amount" id="amount" class="form-control"
                                            value="{{ $transaction->amount }}" disabled />
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('order.status')</label>
                                        <select name="status" id="status" class="form-control text-capitalize select2">
                                            <option value="" selected disabled>@lang('order.chooseStatus')</option>
                                            <option value="Unverified"
                                                <?php if('Unverified' == $transaction->status) { echo 'selected'; } ?>>
                                                Unverified</option>
                                            <option value="Verified"
                                                <?php if("Verified" == $transaction->status) { echo 'selected'; } ?>>
                                                Verified</option>
                                            <option value="Cancelled"
                                                <?php if("Cancelled" == $transaction->status) { echo 'selected'; } ?>>
                                                Cancelled</option>
                                        </select>
                                    </div>

                                    <button class="btn btn-success" type="submit">@lang("common.edit")</button>
                                    <a href="{{ route('transaction.index') }}" class="btn btn-primary">@lang("common.back")</a>
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

</script>
@endsection
