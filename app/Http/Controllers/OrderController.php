<?php

namespace App\Http\Controllers;

use App\Category;
use App\Document;
use App\Customer;
use App\CustomerDocument;
use App\DataTables\OrdersDataTable;
use App\Department;
use App\Message;
use App\Models\Status;
use App\Order;
use App\Requirement;
use App\RequirementTemplateDetail;
use App\Service;
use App\Transaction;
use App\User;
use LogHelper;
use App\Wallet;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $dataTable)
    {
        // $orders = Order::paginate(20);
        // return view('dashboard.orders.index', ['orders' => $orders]);
        return $dataTable->render('dashboard.orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $status = Status::all();
        $customers = Customer::all();
        $categories = Category::all();
        $departments = Department::all();
        $services = Service::all();
        return view('dashboard.orders.edit', compact('order', 'categories', 'departments', 'services', 'customers', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function getOrder(Request $request)
    {
        // $order = Order::where('id', $request->order_id)
        //     ->with(['customer', 'group', 'department.websites', 'category.websites', 'service.websites', 'status'])
        //     ->first();
        $order = Order::find($request->order_id);

        if ($order) {
            // Get all sub categories
            $cats = unserialize($order->cat_ids);
            $categories = [];
            if ($cats) {
                $categories = Category::whereIn('id', $cats)->with('websites')->get();
            }
            $order->all_categories = $categories;
            $html = view('dashboard.orders.order-detail', compact('order'))->render();
        } else {
            $html = "";
        }
        return response()->json($html);
    }

    public function update(Request $request, Order $order)
    {
        $validatedData = $request->validate([
            'status_id'         => 'required|numeric',
            'agreed_fee'        => 'required|numeric',
            'expiry_date'       => 'required',
            'proof_img'         => 'image',
        ]);
        $verified = true;

        // Check Transaction
        if (isset($validatedData['status_id']) && ($validatedData['status_id'] == 3 || $validatedData['status_id'] == 4)) {
            $verified = self::checkPaymentVerification($order);
        }

        if (!$verified && $order->status_id != $request->input('status_id')) {
            $message = "Status cannot be changed. Because payment is unverified.";
            $request->session()->flash('error', true);
        } else {
            if ($order->status_id == '4' || $order->status_id == '5') {
                $message = "Order can't be changed. Because order status already " . ucwords($order->status->name);
                $request->session()->flash('error', true);
            } else {
                $error = false;
                if ($request->input('status_id') == 1 || $request->input('status_id') == 2) {
                    $date = Carbon::parse($validatedData['expiry_date']);
                    $today = Carbon::now();
                    if ($date < $today) {
                        $error = true;
                        $message = translateMessage("messages.expireDateLess");
                        $request->session()->flash('error', true);
                    }
                }

                if (!$error) {
                    $customer = Customer::find($order->customer_id);
                    if ($order->status_id != $request->status_id) {
                        $status = Status::find($request->status_id);
                        LogHelper::send_notification_FCM($customer, translateNotification(__('notification.title.order_updated')), translateNotification(__('notification.order_updated',['order_no' => changeToArabicDigits($order->order_no),'name' => ucwords($status->name)])), $order->id, 'order', 'customer');
                    }

                    $order->status_id       = $request->input('status_id');
                    $order->expiry_date     = $request->input('expiry_date');

                    // update transactions
                    if ($order->agreed_fee != $validatedData['agreed_fee']) {
                        LogHelper::send_notification_FCM($customer, translateNotification(__('notification.title.order_updated')),  translateNotification(__('notification.order_updated_with_fee',['order_no' => changeToArabicDigits($order->order_no),'fee' => changeToArabicDigits($request->agreed_fee)])), $order->id, 'order', 'customer');
                        // Update amount in transaction
                        $transactions       = Transaction::where('order_id', $order->id)->get();
                        foreach ($transactions as $transaction) {
                            $transaction->amount = $validatedData['agreed_fee'];
                            $transaction->save();

                            ////////////////// update amounnt in wallet
                            $wallets = Wallet::where('transaction_id', $transaction->id)->get();
                            foreach ($wallets as $wallet) {
                                $wallet->amount = ($wallet->amount < 0) ? '-' . $validatedData['agreed_fee'] : $validatedData['agreed_fee'];
                                $wallet->save();
                            }
                        }
                    }

                    $order->agreed_fee      = $request->input('agreed_fee');
                    if ($request->hasFile('proof_img')) {
                        $file_name = $order->order_no . "." . $request->proof_img->getClientOriginalExtension();
                        $request->proof_img->move(public_path('images_orders'), $file_name);
                        $order->proof_img = $file_name;
                    }
                    $order->save();

                    if ($request->input('status_id') == '5') {
                        $transaction = Transaction::where('order_id', $order->id)->first();
                        $transaction->status = 'Cancelled';
                        $transaction->save();

                        $wallets = Wallet::where('transaction_id', $transaction->id)->get();
                        foreach ($wallets as $wallet) {
                            $wallet->delete();
                        }
                    }

                    $message =translateMessage("messages.orderUpdate");
                }
            }
        }

        $request->session()->flash('message', $message);
        return redirect()->route('order.index');
    }

    static public function checkPaymentVerification($order)
    {
        if ($order->transactions['status'] === 'Unverified') {
            return false;
        }
        return true;
    }

    public function fetchTransaction(Request $request)
    {
        $transactions = Transaction::where('order_id', $request->input('order_id'))->first();
        return response()->json($transactions);
    }

    public function fetchRequirements(Request $request)
    {
        $mainObj = [];
        $html = "";
        $order = Order::find($request->order_id);
        $asssoc_data = json_decode($order->customer_requirement_data, true);
        if (!empty($asssoc_data)) {
            $ind = 0;
            foreach ($asssoc_data as $key => $value) {
                $req_detail_id = $key;
                $customer_document_id = $value;
                if(strpos($customer_document_id, '_') !== false){
                    $req_detail_id = $value;
                    $customer_document_id = $key;
                }
                $strArray       = explode('_', $req_detail_id);
                // dd($customer_document_id);
                $req_detail_id  = end($strArray);
                $req_detail     = Document::find($req_detail_id);
                $document = CustomerDocument::find($customer_document_id);
                if(empty($req_detail)){
                    $req_detail     = Document::find($customer_document_id);
                    $document = CustomerDocument::find($req_detail_id);
                }
                // dd(collect($document)->toArray());
                if(!empty($document) && !empty($req_detail)){
                    // get template for first time
                    if ($ind === 0) {
                        $mainObj['template_name'] = $req_detail->name;
                    }
                    $mainObj['array'][$ind]['customer_document']['label']        = $req_detail->name;
                    $mainObj['array'][$ind]['customer_document']['data']         = $document;
                    $dataModel = json_decode($mainObj['array'][$ind]['customer_document']['data']->dataModel, true);
                    foreach ($dataModel as $key => $value) {
                        unset($dataModel[$key]);
                        if ($key !== 'user_id' && $key !== 'template' && $key !== 'user_type' && $key !== 'document_id') {
                            $key = ucwords(preg_replace('/\_+/', ' ', $key));
                            $dataModel[$key] = $value;
                        }
                    }
                    $mainObj['array'][$ind]['customer_document']['dataModel'] = $dataModel;

                    $ind++;
                }
            }
            
            $html = view('dashboard.orders.requirements', ['data' => $mainObj])->render();
        }
        // $requirements = Requirement::where('order_id', $request->order_id)->first();
        // $dataModel = [];
        // if ($requirements) {
        //     $dataModel = json_decode($requirements->dataModel, true);
        //     foreach ($dataModel as $key => $value) {
        //         unset($dataModel[$key]);
        //         if ($key !== 'order_id') {
        //             $key = ucwords(preg_replace('/\_+/', ' ', $key));
        //             $dataModel[$key] = $value;
        //         }
        //     }
        // }
        return response()->json(['html' => $html]);
    }

    public function fetchMessages(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
        ]);
        $order = Order::find($request->input('order_id'));
        // check all as read message.
        $order->changeMessageAsRead('App\Customer');

        $results = DB::select('SELECT messages.*, users.name as admin_name, concat(customers.first_name, " ", customers.last_name) as customer_name  from messages
        LEFT JOIN users on users.id = messages.user_id
        LEFT JOIN customers on customers.id = messages.user_id
        WHERE order_id = :order_id', ['order_id' => $request->input('order_id')]);

        return response()->json($results);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'message' => 'required',
        ]);
        $user = auth()->user();

        $message = new Message();
        $message->order_id = $request->input('order_id');
        $message->message = $request->input('message');
        $message->user_id = $user->id;
        $message->user_type = 'App\User';
        $message->save();

        $user = Customer::find($message->order->customer_id);
        LogHelper::send_notification_FCM($user, translateNotification(__('notification.title.new_message')), translateNotification(__('notification.new_message',['order_no' => changeToArabicDigits($message->order->order_no)])), $message->order_id, 'new_message', 'customer');

        return response()->json([
            'message' => translateMessage("message.noteSend"),
        ]);
    }

    public function updateTransactionStatus(Request $request)
    {
        $request->validate([
            'transaction_id' => "required",
            'status' => "required",
        ]);
        $transaction = Transaction::find($request->input('transaction_id'));
        $ord_status_id = $transaction->order->status_id;
        $status_name = $transaction->order->status->name;

        if ($request->status === 'Unverified' && ($ord_status_id == 2 || $ord_status_id == 3 || $ord_status_id == 4)) {
            return response()->json([
                'message' => translateMessage("message.cannotChangeStatus")."{$status_name}!",
            ]);
        } else {
            $transaction->status = $request->input('status');

            $wallets    = Wallet::where('transaction_id', $transaction->id)->get();
            if (count($wallets) > 0) {
                foreach ($wallets as $wallet) {
                    $wallet->delete();
                }
            }

            if ($transaction->status === 'Verified') {
                if ($transaction->from_type === 'App\User') {
                    $user_from  = User::where('account_no', $transaction->from_acc_id)->first();
                } else {
                    $user_from  = Customer::where('account_no', $transaction->from_acc_id)->first();
                }
                // From Transaction
                $wallet = new Wallet();
                $wallet->user_type      = $transaction->from_type;
                $wallet->user_id        = $user_from->id;
                $wallet->transaction_id = $transaction->id;
                $wallet->amount         = '-' . $transaction->amount;
                $wallet->save();

                // To Transaction
                if ($transaction->to_type === 'App\User') {
                    $user_to  = User::where('account_no', $transaction->to_acc_id)->first();
                } else {
                    $user_to  = Customer::where('account_no', $transaction->to_acc_id)->first();
                }
                $to_wallet = new Wallet();
                $to_wallet->user_type       = $transaction->to_type;
                $to_wallet->user_id         = $user_to->id;
                $to_wallet->amount          = $transaction->amount;
                $to_wallet->transaction_id  = $transaction->id;
                $to_wallet->save();
            }

            $transaction->save();

            return response()->json([
                'message' =>translateMessage("message.statusUpdate"),
            ]);
        }
    }

    public function getOrderbyCustomer(Request $request)
    {
        $filter_type = $request->filter;
        $customer_id = $request->id;

        if ($customer_id) {
            if ($filter_type) {
                $orders = Order::where(["customer_id" => $customer_id, 'status_id' => $filter_type])
                    ->with('category')
                    ->with('department')
                    ->with('service')
                    ->with('status')->get();
            } else {
                $orders = Order::where("customer_id", $customer_id)
                    ->with('category')
                    ->with('department')
                    ->with('service')
                    ->with('status')->get();
            }

            if (count($orders) > 0) {
                foreach ($orders as $key => $value) {
                    $orders[$key]['unread_msg'] = $orders[$key]->getUnreadMessageCount('App\User');
                }

                return response()->json([
                    'result' => TRUE,
                    'message' =>translateMessage("message.orderFound"),
                    'orders' => $orders,
                ]);
            } else {
                return response()->json([
                    'result' => FALSe,
                    'message' => translateMessage("message.orderNotFound"),
                ]);
            }
        } else {
            return response()->json([
                'result' => FALSE,
                'message' => translateMessage("message.customerMissing"),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, Request $request)
    {
        if ($order) {
            $order->delete();
        }
        $request->session()->flash('message', translateMessage("message.orderDelete"));
        return redirect()->route('order.index');
    }
}
