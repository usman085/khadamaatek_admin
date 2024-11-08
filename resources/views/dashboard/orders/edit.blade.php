@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('order_edit') }}
@endsection

@section('css')
<style>
    .select2-results,
    .select2-selection__rendered {
        text-transform: uppercase;
    }

</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4>@lang("order.editOrder")</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('order.update', $order->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>@lang("order.order") #</label>
                                        <input class="form-control" type="text" placeholder="Order#"
                                            value="{{ $order->order_no }}" disabled readonly />
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                        <label>Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-control select2" disabled>
                                            <option value="">Choose Customer</option>
                                            <?php // $selected = "selected"; ?>
                                            @foreach ($customers as $item)
                                            <option value="{{ $item->id }}"
                            <?php // if($item->id == $order->customer_id) { echo $selected; } ?>>
                            {{ $item->first_name }} {{ $item->last_name }}</option>
                            @endforeach
                            </select>
                    </div>

                    <div class="form-group">
                        <label>Department</label>
                        <select name="department_id" id="department_id" class="form-control select2" disabled>
                            <option value="">Choose Department</option>
                            <?php // $selected = "selected"; ?>
                            @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}"
                                <?php // if($dept->id == $order->department_id) { echo $selected; } ?>>
                                {{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Service Category</label>
                        <select name="category_id" id="category_id" class="form-control select2" disabled>
                            <option value="">Choose Category</option>
                            <?php // $selected = "selected"; ?>
                            @foreach ($categories as $item)
                            <option value="{{ $item->id }}"
                                <?php // if($item->id == $order->category_id) { echo $selected; } ?>>
                                {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" id="service_id" class="form-control select2" disabled>
                            <option value="">Choose Service</option>
                            <?php // $selected = "selected"; ?>
                            @foreach ($services as $item)
                            <option value="{{ $item->id }}"
                                <?php // if($item->id == $order->service_id) { echo $selected; } ?>>
                                {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang("order.proofImage")</label>
                                <input type="file" name="proof_img" id="proof_img" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label>@lang("order.agreedFee")</label>
                                <input type="text" name="agreed_fee" id="agreed_fee" class="form-control"
                                    value="{{ $order->agreed_fee }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>@lang("order.order") @lang("order.status")</label>
                                <select name="status_id" id="status_id" class="form-control text-uppercase select2">
                                    <option value="" selected disabled>@lang("order.chooseStatus") </option>
                                    <?php // $selected = "selected"; ?>
                                    @foreach ($status as $item)
                                    <option value="{{ $item->id }}" @if ($item->id === $order->status_id)
                                        {{ "selected" }} @endif
                                        <?php // if($item->id == $order->status_id) { echo $selected; } ?>>
                                        <span class="text-uppercase">{{ $item->name }}</span>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label for="expiry_date">@lang("order.expireDate")</label>
                                <input id="expiry_date" name="expiry_date" class="form-control"
                                    placeholder="@lang('order.expireDate')" value="{{ $order->expiry_date }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-success" type="submit">@lang("common.edit")</button>
                            <a href="{{ route('order.index') }}" class="btn btn-primary">@lang("common.back")</a>
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
    $('#expiry_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        iconsLibrary: 'fontawesome',
    });

</script>
@endsection
