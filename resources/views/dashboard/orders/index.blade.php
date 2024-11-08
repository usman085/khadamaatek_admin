@extends('dashboard.base')

@section('breadcrumbs')
{{ Breadcrumbs::render('orders') }}
@endsection
@php
    $current_locale = Session::get('current_locale','en');
    $locale_array = ['en'=>'English','ar'=>'Arabic']
@endphp
@section('css')
<style>
.order-detail-heading {
    font-size: 16px;
    display: inline-block;
    font-weight: 600;
    margin-bottom: 12px;
}

.order-detail-value {
    font-size: 16px;
    font-weight: 400;
    display: inline-block;
    float: right;
}

.chat-box {
    min-height: 200px;
    max-height: 350px;
    border: 1px solid #ddd;
    border-bottom: none;
    position: relative;
    overflow-y: auto;
    padding: 5px 15px;
}

.message-box {
    display: flex;
    padding:7px;
    /* border-bottom: 1px solid #ddd; */
    flex-direction: column;
}

.user-name {
    font-weight: 600;
}

.msg-time {
    font-size: 10px;
    color: #ccc;
}

.msg-text {
    font-size: 12px;
}

.user-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
}

.badge.badge-pill {
    top: -8px;
    right: 4px;
}

.btnShowMessages {
    padding-left: 6px;
    padding-right: 6px;
}

a.disabled-link,
a.disabled-link:not([href]) {
    color: #fff;
    background: #321fdb98;
    cursor: default;
    pointer-events: none;
    text-decoration: none;
}
.msg-text-other {
    display: flex;
    justify-content: flex-end;
}
    #orders-table{
        width: 100% !important;
    }

</style>
@if($current_locale == "ar")
    <style>
        #orders-table{
            text-align: right;
        }
    </style>
@endif
@endsection

@section('content')

<div class="container-fluid">
    <div class="modal fade" id="viewOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="viewOrderDetailModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <div class="modal fade" id="transactionsModal" tabindex="-1" role="dialog" aria-labelledby="transactionsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang("order.transaction")</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover transactionTable">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>@lang("order.fromBank")</th>
                                        <th>@lang("order.fromAcc")</th>
                                        <th>@lang("order.ammount")</th>
                                        <th>@lang("order.toBank")</th>
                                        <th>@lang("order.toAcc")</th>
                                        <th>@lang("order.status")</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (isset($change))
                    <button type="button" class="btn btn-primary changeStatus" data-dismiss="modal"
                        data-order_id="0">@lang('order.changeStatus')</button>
                    @endif
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="requirementsModal" tabindex="-1" role="dialog" aria-labelledby="requirementsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('order.reqDetail')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover requirementsTable">
                                <thead>
                                    <tr>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="messagesModal" tabindex="-1" role="dialog" aria-labelledby="messagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('order.notifications')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="chat-box">

                            </div>
                            <div class="input-group">
                                <input class="form-control" type="text" id="message" placeholder="@lang('order.typeNot')">
                                <div class="input-group-append">
                                    <a class="input-group-text bg-primary text-white" id="sendMessage"
                                        data-toggle="tooltip" data-placement="top" title="Send Message"
                                        data-original-title="Send Message" data-order_id="0" data-dismiss="modal">
                                        <i class="cil-send"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary changeStatus" data-dismiss="modal"
                        data-order_id="0">Change Status</button> --}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('common.close')</button>
                </div>
            </div>
        </div>
    </div>

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-header {{$current_locale == "en"? '':'align-right'}}">
                        @if($current_locale == "en")
                        <i class="fa fa-align-justify"></i> @lang("order.order")
                        @else
                            @lang("order.order") <i class="fa fa-align-justify"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(Session::has('message'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                            </div>
                        </div>
                        @endif
                        <div class="reponse-message d-none alert alert-success" role="alert"></div>
                        {{-- <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Order#</th>
                                    <th>Customer</th>
                                    <th>Department</th>
                                    <th>Category</th>
                                    <th>Service</th>
                                    <th>Fee</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    {{-- <th></th> --}}
                        {{-- </tr>
                            </thead>
                            <tbody>
                                <?php// $i=1; ?>
                                @foreach($orders as $order)
                                <tr>
                                    <td><strong>{{ $i++ }}</strong></td>
                        <td><strong>{{ $order->order_no }}</strong></td>
                        <!-- <td><strong>{{ $order->customer['first_name'] }} -->
                                {{ $order->customer['last_name'] }}</strong></td>
                        <td><strong>{{ $order->department['name'] }}</strong></td>
                        <td><strong>{{ $order->category['name'] }}</strong></td>
                        <td><strong>{{ $order->service['name'] }}</strong></td>
                        <td><strong>{{ $order->agreed_fee }}</strong></td>
                        <td>
                            <span class="{{ $order->status->class }} text-uppercase">
                                {{ $order->status->name }}
                            </span>
                        </td>
                        <td>
                            <button class="d-none showTransactionModal" data-toggle="modal"
                                data-target="#transactionsModal"></button>
                            <a href="#" class="btn btn-info btn-sm btnShowTransaction" title="Show Transaction"
                                data-id="{{$order->id}}"><i class="cil-credit-card"></i></a>
                        </td>
                        <td>
                            <button class="d-none showMessageModal" data-target="#messagesModal"
                                data-toggle="modal"></button>
                            <a href="#" class="btn btn-secondary btn-sm btnShowMessages" title="Notifications"
                                data-id="{{$order->id}}">
                                <i class="cil-bell c-icon"></i>
                                <span
                                    class="badge badge-pill badge-danger">{{ $order->getUnreadMessageCount("App\Customer") }}</span>
                            </a>
                        </td>
                        <td>
                            <button class="d-none showRequirementsModal" data-target="#requirementsModal"
                                data-toggle="modal"></button>
                            <a href="#" class="btn btn-warning btn-sm btnShowRequirements"
                                title="Show Requirement Details" data-id="{{$order->id}}">
                                <i class="cil-file"></i></a>
                        </td>
                        <td>
                            @if ($order->status_id == '4')
                            <a title="Change Order Status" class="btn btn-primary btn-sm disabled-link">
                                <i class="cil-pencil"></i></a>
                            @else
                            <a href="{{ url('/admin/order/' . $order->id . '/edit') }}" title="Change Order Status"
                                class="btn btn-primary btn-sm">
                                <i class="cil-pencil"></i></a>
                            @endif
                        </td>
                        @if (isset($delt)) --}}
                        {{-- <td>
                                        <form action="{{ route('order.destroy', $order->id ) }}"
                        onsubmit="return confirm('Are you sure to delete?')" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger  btn-sm" title="Delete Order">
                            <i class="cil-trash"></i>
                        </button>
                        </form>
                        </td> --}}
                        {{-- @endif
                                </tr> --}}
                        {{-- @endforeach --}}
                        {{-- </tbody>
                        </table>
                        {{ $orders ?? ''->links() }} --}}
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('javascript')
{{$dataTable->scripts()}}

<script>
    var element = document.getElementById("orders-table");
    element.classList.add("table-responsive");
    function appendDataToTable(data) {
    let table = $('.transactionTable');
    let tr = "";
    tr = "<tr>";
    tr += "<td>1</td>";
    tr += `<td>${(data.from_bank_name) ? data.from_bank_name : "-"}</td>`;
    tr += `<td>${data.from_bank_accno}</td>`;
    tr += `<td>${data.amount}</td>`;
    tr += `<td>${(data.to_bank_name) ? data.to_bank_name : "-"}</td>`;
    tr += `<td>${data.to_bank_accno}</td>`;
  
    if ( data.status=="Verified") {
        tr +=   `<td>@lang('setting.Verified')</td>`;
        
    }
    else if(data.status=="Unverified"){
        tr +=   `<td>@lang('setting.Unverified')</td>`;
    
    }
    else{
        tr +=   `<td>@lang('setting.Cancelled')</td>`;
    }
    // tr += `<td>`;
    // tr += `<select class='form-control payment_status'>`;
    // tr += `<option value='Unverified' ${(data.status == 'Unverified') ?  'selected' : ""}>Unverified</option>`;
    // tr += `<option value='Verified' ${(data.status == 'Verified') ?  'selected' : ""}>Verified</option>`;
    // tr += `</select>`;
    // tr += `</td>`;
    tr += "</tr>";
    table.append(tr);

}

function fetchOrderDetail(order_id) {
    $.ajax({
        url: "{{ route('fetch.orderdetail') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            "order_id": order_id
        },
        success: function(data) {
            // console.log(data);
            $('#viewOrderDetailModal .modal-content').html(data)
            $('.viewOrderDetailModal').trigger('click');
            // $('.transactionTable tbody').html('');
            // $('.changeStatus').data('order_id', "");
            // if (data.status) {
            //     appendDataToTable(data);
            // }
            // $('.changeStatus').data("order_id", data.id);
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function fetchTransaction(order_id) {
    $.ajax({
        url: "{{ route('fetch.transaction') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            "order_id": order_id
        },
        success: function(data) {
            $('.transactionTable tbody').html('');
            $('.changeStatus').data('order_id', "");
            if (data.status) {
                appendDataToTable(data);
            }
            $('.changeStatus').data("order_id", data.id);
            $('.showTransactionModal').trigger('click');
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function fetchCustomerRequirements(order_id) {
    $.ajax({
        url: "{{ route('fetch.requirements') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            "order_id": order_id
        },
        success: function(data) {
            let html =
                "<div class='modal-header'><h5 class='modal-title'>Requirement Details Not Exist</h5><button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            if (data.html !== "") {
                $('#requirementsModal .modal-content').html(data.html);
            } else {
                $('#requirementsModal .modal-content').html(html);
            }
            // if (data) {
            // for (var prop in data) {
            //     html += "<tr>";
            //     html += `<th>${prop}</th>`;
            //     if (data[prop] && data[prop].includes("attachment")) {
            //         html += `<td>`;
            //         html += `<a href='/requirements_attach/${data[prop]}' target='_blank'>`;
            //         html +=
            //             `<img src='/requirements_attach/${data[prop]}' class='img-fluid' alt='${data[prop]}' style="max-height: 220px;" />`;
            //         html += "</a>";
            //         html += `</td>`;
            //     } else {
            //         if (data[prop].search('dateTimeStamp-') !== -1) {
            //             var timestamp = data[prop].replace("dateTimeStamp-", "");
            //             var date = new Date( parseInt(timestamp) );
            //             html += `<td>` + date.getFullYear() + "/" + (date.getMonth() + 1) + "/" + date.getDate() + `</td>`;
            //         } else {
            //             html += `<td>${(data[prop]) ? data[prop] : '-'}</td>`;
            //         }
            //     }
            //     html += "</tr>";
            // }
            // }
            // $('.requirementsTable tbody').html(html);
            $('.showRequirementsModal').trigger('click');
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function sendMessage(order_id, message) {
    $.ajax({
        url: "{{ route('send.message') }}",
        type: "POST",
        data: {
            "order_id": order_id,
            "message": message
        },
        dataType: "JSON",
        success: function(data) {
            $('.reponse-message').text(data.message).removeClass('d-none');
            setTimeout(() => {
                $('.reponse-message').text("").addClass('d-none');
                $('#message').val('');
            }, 2000);
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function fetchMessages(order_id) {
    const loggedin = JSON.parse(localStorage.getItem("user"));
    $.ajax({
        url: "{{ route('fetch.messages') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            "order_id": order_id
        },
        success: function(data) {

            $('.chat-box').html('');
            $('#sendMessage').data("order_id", order_id);
            let html = "";
            data.forEach(element => {
                let add_date = new Date(element.created_at);
                add_date = add_date.getFullYear() + "-" + (add_date.getMonth() + 1) + "-" +
                    add_date.getDate() + " " + add_date.getHours() + ":" + add_date
                    .getMinutes() + ":" + add_date.getSeconds();
                if (element.user_id != loggedin.user.id) {
                    html += '<div class="message-box">';
                    html += `<div class="user-info">`;
                    if (element.user_type == "App\\Customer") {
                        html += `<span class="user-name">${element.customer_name}</span>`;
                    } else {
                        html += `<span class="user-name">${element.admin_name}</span>`;
                    }
                    html += `<span class="msg-time">${ add_date}</span>`;
                    html += `</div>`;
                    html += `<span class="msg-text">${element.message}</span>`;
                    html += '</div>';
                } else {
                    html += '<div class="message-box">';
                    html += `<div class="user-info">`;
                    html += `<span class="msg-time">${ add_date}</span>`;
                    if (element.user_type == "App\\Customer") {
                        html += `<span class="user-name">${element.customer_name}</span>`;
                    } else {
                        html += `<span class="user-name">${element.admin_name}</span>`;
                    }
                
                    html += `</div>`;
                    html += `<span class="msg-text-other">${element.message}</span>`;
                    html += '</div>';
                }

            });
            $('.chat-box').html(html);
            $('.showMessageModal').trigger('click');
            setTimeout(() => {
                $(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
            }, 300);
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function updateStatus(trans_id, status) {
    $.ajax({
        url: "{{ route('transaction.update_status') }}",
        type: "POST",
        dataType: "JSON",
        data: {
            "transaction_id": trans_id,
            "status": status
        },
        success: function(data) {
            if (data.message) {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                };
                toastr.success(data.message);
            }
            $('.reponse-message').text(data.message).removeClass('d-none');
            setTimeout(() => {
                $('.reponse-message').text("").addClass('d-none');
            }, 2000);
        },
        error: function(requestObject, error, errorThrown) {
            console.log(errorThrown);
        }
    });
}

window.onload = () => {
    $('body').on('click', '.btnShowOrderDetail', function(e) {
        e.preventDefault();

        let order_id = $(this).data('id');
        fetchOrderDetail(order_id);
    });

    $('body').on('click', '.btnShowTransaction', function(e) {
        e.preventDefault();

        let order_id = $(this).data('id');
        fetchTransaction(order_id);
    });

    $('body').on('click', '.btnShowRequirements', function(e) {
        e.preventDefault();
        let order_id = $(this).data('id');
        fetchCustomerRequirements(order_id);
    });

    $('body').on('click', '.btnShowMessages', function(e) {
        e.preventDefault();

        let order_id = $(this).data('id');
        fetchMessages(order_id);
    });

    $('body').on('click', '#sendMessage', function(e) {
        let order_id = $(this).data('order_id');
        let message = $('#message').val();
        sendMessage(order_id, message);
    });

    $('body').on('click', '.changeStatus', function(e) {
        e.preventDefault();
        let transac_id = $(this).data('order_id')
        let status = $('.payment_status').val();
        updateStatus(transac_id, status);
    });
}
</script>

@endsection