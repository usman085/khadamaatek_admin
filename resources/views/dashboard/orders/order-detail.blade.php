<div class="modal-header">
    <h5 class="modal-title">@lang('order.order_no'): <span class="order_no font-weight-bold">{{ $order->order_no }}</span></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('order.customer') @lang('common.name'):</h3>
            <h3 class="order-detail-value">
                @if($order->customer)
                {{ $order->customer->first_name }} {{ $order->customer->last_name }}
                    @endif
            </h3>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('service.fee') :</h3>
            <h3 class="order-detail-value">{{ $order->agreed_fee }}</h3>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('order.status') :</h3>
            <h3 class="order-detail-value text-uppercase">
                <span class="{{ $order->status->class }}">@lang('customer.'.$order->status->name)</span>
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('group.group') @lang('common.name') </h3>
            <h3 class="order-detail-value">{{ ($order->group) ? $order->group->name : "" }}</h3>
        </div>
    </div>
    {{-- Department --}}
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('department.department') @lang('common.name') </h3>
            <h3 class="order-detail-value">{{ $order->department->name }}</h3>
        </div>
        @if (count($order->department->websites) > 0)
            @include('dashboard.orders.website', ['websites' => $order->department->websites])
        @endif
    </div>

    {{-- Category --}}
    @if (count($order->all_categories) > 0)
        @foreach ($order->all_categories as $key => $value)
            {{-- Show main category --}}
            @if ($key == 0)
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="order-detail-heading">@lang('order.category')</h3>
                        <h3 class="order-detail-value">{{ $value->name }}</h3>
                    </div>
                    @if (count($value->websites) > 0)
                        @include('dashboard.orders.website', ['websites' => $value->websites])
                    @endif
                </div>
            @else
                {{-- Show sub categories category --}}
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="order-detail-heading">@lang('service.subCategory')</h3>
                        <h3 class="order-detail-value">{{ $value->name }}</h3>
                    </div>
                    @if (count($value->websites) > 0)
                        @include('dashboard.orders.website', ['websites' => $value->websites])
                    @endif
                </div>
            @endif
        @endforeach
    @else
        <div class="row">
            <div class="col-md-12">
                <h3 class="order-detail-heading">@lang('order.category')</h3>
                <h3 class="order-detail-value">{{ $order->category->name }}</h3>
            </div>
            @if (count($order->category->websites) > 0)
                @include('dashboard.orders.website', ['websites' => $order->category->websites])
            @endif
        </div>
    @endif

    {{-- Service --}}
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('order.category')</h3>
            <h3 class="order-detail-value">{{ $order->service->name }}</h3>
        </div>
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('order.serviceNumber')</h3>
            <h3 class="order-detail-value">{{ $order->service->id }}</h3>
        </div>
        @if (count($order->service->websites) > 0)
            @include('dashboard.orders.website', ['websites' => $order->service->websites])
        @endif
    </div>

    {{-- Service --}}
    <div class="row">
        <div class="col-md-12">
            <h3 class="order-detail-heading">@lang('order.orderDate')</h3>
            <h3 class="order-detail-value">{{ date('Y-m-d h:i:s A',strtotime($order->created_at)) }}</h3>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
</div>
