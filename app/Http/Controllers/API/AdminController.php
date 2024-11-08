<?php

namespace App\Http\Controllers\API;

use App\BankAccount;
use App\Customer;
use App\CustomerDocument;
use App\Document;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Mail\NotificationEmail;
use App\Message;
use App\Models\Status;
use App\NumberChangeRequest;
use App\Order;
use App\Service;
use App\Transaction;
use App\User;
use App\UserNotification;
use App\Wallet;
use Carbon\Carbon;
use LogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Html\Editor\Fields\Number;
// use Auth;

class AdminController extends Controller
{
    public function getStatistics($id)
    {
        $user               = User::find($id);
        $balance            = Wallet::where(['user_id' => $id, 'user_type' => "App\User"])->sum('amount');
        $total_customers    = Customer::count();
        $total_services     = Order::count();
        $pending_orders     = Order::where('status_id', 1)->count();
        $inprocess_orders   = Order::where('status_id', 2)->count();
        $completed_orders   = Order::where('status_id', 4)->count();
        $cancelled_orders   = Order::where('status_id', 5)->count();
        $unread_messages    = $user->notifications->where('is_read', 0)->count();
        $data = compact('user', 'balance', 'total_customers', 'total_services', 'pending_orders', 'inprocess_orders', 'completed_orders', 'cancelled_orders', 'unread_messages');

        $response = [
            'result'    => TRUE,
            "data"   =>  $data,
        ];
        return response()->json($response);
    }

    public function getBankDetails($id)
    {
        $bankDetails        = BankAccount::where(['user_id' => $id, 'user_type' => "App\User"])->first();
        if ($bankDetails) {
            $response = [
                'result' => TRUE,
                "data"   =>  $bankDetails,
            ];
        }
        return response()->json($response);
    }

    public function getDocuments()
    {
        $response = [
            'result' => TRUE,
            "data"   =>  Document::all(),
        ];
        return response()->json($response);
    }
    public function deleteCustomerDocument($customer_document_id){
        $response = [
            'result' => FALSE,
            "data"   =>  [],
            "message"   =>  translateMessage('messages.document_not_found'),
        ];
        $customer_document = CustomerDocument::find($customer_document_id);
        if(!empty($customer_document)){
            $customer_document->delete();
            $response = [
                'result' => TRUE,
                "data"   =>  [],
                "message"   =>  translateMessage('messages.document_deleted'),
            ];
        }
        return response()->json($response);
    }
    public function getDocumentsForMobile()
    {
	
//return response()->json('{"name":"John", "age":30, "car":null}');

        $documents = Document::all();
        if (count($documents) > 0) {
            foreach ($documents as $key => $value) {
                $schema = json_decode($value->schema, true);
                // Add customer field document name.
                $document_model = [
                    "type" => "input",
                    "label" => "Document Name",
                    "model" => "document_name",
                    "readonly" => false,
                    "required" => true,
                    "inputType" => "text",
                    "placeholder" => "Document Name",
                ];
                array_unshift($schema, $document_model);
                $value->schema = $schema;
            }
        }
//return response()->json("data"=>$documents);
        $response = [
            'result' => TRUE,
            "data"   =>  json_decode($documents),
        ];

        return response()->json($response);
    }


    public function getCustDocumentById(CustomerDocument $document)
    {
        $response = [
            'result' => TRUE,
            "document"   =>  $document,
        ];
        return response()->json($response);
    }

    public function getCustomerDocumentById(CustomerDocument $document)
    {
        $document->dataModel = json_decode($document->dataModel, true);
        $response = [
            'result' => TRUE,
            "document"   =>  $document,
        ];
        return response()->json($response);
    }

    public function getCustomerDocumentWithSchemaById(int $customer_doc_id)
    {
       // dd($customer_doc_id);
        // $document = Document::find($customer_doc_id);
        $cust_document = CustomerDocument::where(['id' => $customer_doc_id, 'user_type' => "App\Customer"])->first();
        $document = Document::where('id', $cust_document->document_id)->first();
        $schema = json_decode($document->schema, true);
        // Add customer field document name.
        $document_model = [
            "type" => "input",
            "label" => "Document Name",
            "model" => "document_name",
            "readonly" => false,
            "required" => true,
            "inputType" => "text",
            "placeholder" => "Document Name",
        ];
        array_unshift($schema, $document_model);

        $data_model = json_decode($cust_document->dataModel, true);
        $data = [];
        foreach ($schema as $key => $sk) {
            $model_value = isset($data_model[$sk['model']]) ? $data_model[$sk['model']] : '-';
            if (strpos($model_value, 'dateTimeStamp-') !== false) {
                $sk['value'] = date('Y-m-d', strtotime(str_replace("dateTimeStamp-", "", $model_value)));
            } else {
                $sk['value'] = $model_value;
            }
            $data[] = $sk;
        }
        $cust_document->data_model = $data;
        $response = [
            'result' => TRUE,
            "document"   =>  $cust_document,
        ];
        return response()->json($response);
    }
    public function getDocumentDetailOnly($doc_type,$user_id){
        $documents = Document::where('document_type', $doc_type)->with('requiredTemplateDetail')->get();
        // return (collect($documents)->toArray());
        $customer_documents = [];
        if ($documents) {
            foreach ($documents as $key => $doc) {
                $customer_documents[$key]['data']           = CustomerDocument::where(['document_id' => $doc->id, 'user_id' => $user_id])->get();
            }
            $response = [
                'result'                => TRUE,
                'customer_documents'    => $customer_documents,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.document_not_found'),
            ];
            $responseCode = 404;
        }
        return response()->json($response, $responseCode);
    }
    public function getDocumentByDocId(Document $document, Customer $customer, $customer_doc_id = null)
    {
        $documents = CustomerDocument::where(['user_id' => $customer->id, 'user_type' => "App\Customer", 'document_id' => $document->id])->get();
        $response = [
            'result' => TRUE,
            "data"   =>  [
                'document' => $document,
                'oldDocs'   => $documents,
                'customer_document' => ($customer_doc_id) ? CustomerDocument::find($customer_doc_id) : null,
            ],
        ];
        return response()->json($response);
    }

    public function getDocumentByCustId(Customer $customer, $customer_doc_id = null)
    {
     $documents = Document::all();
        $main_data = [];
        // $documents = CustomerDocument::with('document_template')->where(['user_id' => $customer->id, 'user_type' => "App\Customer"])->get();
        if (count($documents) > 0) {
            foreach ($documents as $key => $value) {
                $schema = json_decode($value->schema, true);
                // Add customer field document name.
                $document_model = [
                    "type" => "input",
                    "label" => "Document Name",
                    "model" => "document_name",
                    "readonly" => false,
                    "required" => true,
                    "inputType" => "text",
                    "placeholder" => "Document Name",
                ];
                array_unshift($schema, $document_model);
                // get all docs
           $cust_documents = CustomerDocument::where(['document_id' => $value->id, 'user_id' => $customer->id, 'user_type' => "App\Customer"])->get();
                if (count($cust_documents) > 0) {
                    foreach ($cust_documents as $k => $v) {
                        $data_model = json_decode($v->dataModel, true);
                        $data = [];
                        foreach ($schema as $sk) {
                            if(isset($sk['model']) && isset($data_model[$sk['model']])){
                             $model_value = $data_model[$sk['model']];
				
                                if (gettype($model_value) != 'array' && strpos($model_value, 'dateTimeStamp-') !== false) {
                                 $sk['value'] = date('Y-m-d', strtotime(str_replace("dateTimeStamp-", "", $model_value)));
                                } else {
                                 $sk['value'] = $model_value;
                                }
                            }
                  $data[] = $sk;
                        }
                  $v->data_model = $data;
          $cust_documents[$k]->document_type = $value->document_type;
                    }
         $main_data[] = $cust_documents;
                }
            }

        }
	 $response = [
            'result' => TRUE,
            "data"   =>  [
                'documents' => $main_data,
                // 'customer_document' => ($customer_doc_id) ? CustomerDocument::find($customer_doc_id) : null,
            ],
        ];
        return response()->json($response);
    }

    public function getServices()
    {
        $orders = Order::with('customer')
            ->with('group')
            ->with('department')
            ->with('category')
            ->with('status')
            ->with('service.logo')
            ->with('transactions')->get();

        foreach ($orders as $key => $value) {

            $main_cat = null;
            $last_subcat = $orders[$key]->category;
            while ($last_subcat && $last_subcat->parent_category) {
                $main_cat = $last_subcat->parent_category;
                $last_subcat = $main_cat;
            }

            $orders[$key]->main_category = $main_cat;

        }

        $response = [
            'result'    => TRUE,
            "data"      =>  $orders,
        ];
        return response()->json($response);
    }

    public function getCustomers()
    {
        $results = Customer::withCount(['wallet as total_balance' => function ($query) {
            $query->select(DB::raw("IFNULL(SUM(amount), 0) as balance"))->where('user_type', 'App\Customer');
        }])->withCount(['orders as all_orders' => function ($query) {
            // $query->where('status_id', 4);
        }])->get();

        $response = [
            'result'    => TRUE,
            "data"      => $results,
        ];
        return response()->json($response);
    }

    public function getTransactions()
    {
        $response = [
            'result'    => TRUE,
            "data"      => Transaction::with('from_customer')->with('to_customer')->with('from_user')->with('to_user')->get(),
        ];
        return response()->json($response);
    }

    public function getDepositTransactions()
    {
        $response = [
            'result'    => TRUE,
            "data"      => Transaction::where('etype', 'bankTransfer')->with('from_customer')->with('to_customer')->with('from_user')->with('to_user')->get(),
        ];
        return response()->json($response);
    }

    public function requestChangeNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'user_type'     => 'required',
            'new_number'    => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'reason'        => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.data_missing'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            if ($request->user_type == 'admin') {
                $user = User::find($request->user_id);
            } else {
                $user = Customer::find($request->user_id);
            }
            $phone_num_without_plus = str_replace('+', '', $request->new_number);
            $phone_num              = '+' . $phone_num_without_plus;

            if ($user) {
                if ($request->user_type == 'admin') {
                    $check_new_number = User::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
                } else {
                    $check_new_number = Customer::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
                }
                if ($check_new_number) {
                    $response = [
                        'result'    => FALSE,
                        'message'   =>translateMessage('messages.new_phone_already_registered'),
                    ];
                    $responseCode = 200;
                } else {
                    $old_req = NumberChangeRequest::where(['user_id' => $user->id, 'status' => 'Pending'])->get();
                    if (count($old_req) === 0) {
                        $req = new NumberChangeRequest();
                        $req->user_id       = $user->id;
                        $req->user_type     = ($request->user_type == 'admin') ? "App\User" : "App\Customer";
                        $req->old_number    = $user->phone_no;
                        $req->new_number    = $request->new_number;
                        $req->reason        = $request->reason;

                        $req->save();


                        LogHelper::store($req->user_id, "User requested to change phone number.");
                        $admins = User::all();
                        foreach ($admins as $admin) {
                            LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.customer_request')), translateNotification(__('notification.request_to_alter_phone_no')), $req->user_id, 'number_change_request');

                            if ($admin->email) {
                                Mail::to($admin->email)->send(new NotificationEmail($req, 'change_number'));
                            }
                        }

                        $response = [
                            'result'    => TRUE,
                            'message'   =>translateMessage('messages.request_set_to_admin'),
                        ];
                    } else {
                        $response = [
                            'result'    => FALSE,
                            'message'   =>translateMessage('messages.request_already_pending'),
                        ];
                        $responseCode = 200;
                    }
                }
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.customer_not_found'),
                ];
                $responseCode = 200;
            }
        }

        return response()->json($response, $responseCode);
    }
    public function getCustomerBalance($customer_id)
    {
        $customer = Customer::find($customer_id);
        $responseCode = 200;
        if ($customer) {
            $response = [
                'result'            => TRUE,
                'balance' => Wallet::where(['user_id' => $customer_id, 'user_type' => "App\Customer"])->sum('amount'),
            ];
        } else {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.customer_not_found')
            ];
            $responseCode = 404;
        }
        return response()->json($response, $responseCode);
    }

    public function getTransactionsByCustomer($customer_id)
    {
        $data = [];
        $responseCode = 200;
        
        // $customer = Customer::find(Auth::id());
        $customer = Customer::find($customer_id);

        $transactions = Transaction::where('from_acc_id', $customer->account_no)->where('status','Verified')->get();

        if (count($transactions) > 0) {
            foreach ($transactions as $key => $value) {
                $value->remaing_bal = $value->remaining_balance($value->id, $customer->id);
                $value->user_account_info = $value->to_type::where('account_no',$value->to_acc_id)->first();
                if($value->etype == 'order'){
                    $value->to_bank_accno = $value->order_id;
                    if(!empty($value->order)){
                        $value->to_bank_accno = $value->order->order_no;
                    }
                }else if($value->etype == 'bankTransfer'){
                    $value->to_bank_accno = $value->to_acc_id;
                }
            }
        }
// check
        if ($customer) {
            $response = [
                'result'            => TRUE,
                "data"              => $transactions,
                'remaining_balance' => Wallet::where(['user_id' => $customer_id, 'user_type' => "App\Customer"])->sum('amount'),
            ];
        } else {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.customer_not_found')
            ];
            $responseCode = 404;
        }
        return response()->json($response, $responseCode);
    }

    public function getNotifications(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $unread_messages = $user->notifications->where('is_read', 0);
            foreach ($unread_messages as $message) {
                $message->is_read = 1;
                $message->save();
            }
            $response = [
                'result'    => TRUE,
                "data"      => $user->notifications,
            ];
        } else {
            $response = [
                'result'    => FALSE,
                'message'   => translateMessage('messages.user_not_found')
            ];
        }
        return response()->json($response);
    }

    public function updateTransactionStatus($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.fail_to_update'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $transaction = Transaction::find($id);
            if ($transaction) {
                $transaction->status = $request->status;
                $transaction->save();

                // Delete old wallet transaction
                $wallets = Wallet::where('transaction_id', $transaction->id)->get();
                if (count($wallets) > 0) {
                    foreach ($wallets as $wallet) {
                        $wallet->delete();
                    }
                }

                if ($transaction->from_type === 'App\User') {
                    $user_from  = User::where('account_no', $transaction->from_acc_id)->first();
                } else {
                    $user_from  = Customer::where('account_no', $transaction->from_acc_id)->first();
                }

                if ($transaction->to_type === 'App\User') {
                    $user_to  = User::where('account_no', $transaction->to_acc_id)->first();
                } else {
                    $user_to  = Customer::where('account_no', $transaction->to_acc_id)->first();
                }

                if ($transaction->status === 'Verified') {
                    // From Transaction
                    $wallet = new Wallet();
                    $wallet->user_type      = $transaction->from_type;
                    $wallet->user_id        = $user_from->id;
                    $wallet->transaction_id = $transaction->id;
                    $wallet->amount         = ($transaction->etype !== 'bankTransfer') ?  '-' . $transaction->amount : $transaction->amount;
                    $wallet->save();

                    // To Transaction
                    if ($transaction->etype != 'bankTransfer') {
                        $to_wallet = new Wallet();
                        $to_wallet->user_type       = $transaction->to_type;
                        $to_wallet->user_id         = $user_to->id;
                        $to_wallet->amount          = $transaction->amount;
                        $to_wallet->transaction_id  = $transaction->id;
                        $to_wallet->save();
                    }
                }

                if ($transaction->etype === 'bankTransfer') {
                    if ($transaction->status === 'Verified') {
                        LogHelper::send_notification_FCM($user_from,translateNotification(__('notification.title.transaction_approved')), translateNotification(__('notification.transaction_approved',['amount' => changeToArabicDigits($transaction->amount)])), $user_from->id, 'transaction', 'customer');
                    } else {
                        LogHelper::send_notification_FCM($user_from,translateNotification(__('notification.title.transaction_cancelled')), translateNotification(__('notification.transaction_cancelled')), $user_from->id, 'transaction', 'customer');
                    }
                } else if ($transaction->etype === 'balanceShare') {
                    $user_from_type = ($transaction->from_type === 'App\\Customer') ? 'customer' : 'admin';
                    $user_to_type = ($transaction->to_type === 'App\\Customer') ? 'customer' : 'admin';
                    if ($transaction->status === 'Verified') {
                        // User From
                        LogHelper::send_notification_FCM($user_from,translateNotification(__('notification.title.transaction_approved')), translateNotification(__('notification.balance_transferred',['amount' => changeToArabicDigits($transaction->amount),'account_no' => changeToArabicDigits($transaction->to_acc_id)])), $user_to->id, 'transaction', $user_from_type);

                        // User To
                        LogHelper::send_notification_FCM($user_to,translateNotification(__('notification.title.transaction_approved')), translateNotification(__('notification.balance_recieved',['amount' => changeToArabicDigits($transaction->amount),'account_no' => changeToArabicDigits($transaction->from_acc_id)])), $user_from->id, 'transaction', $user_to_type);
                    } else {
                        // User From
                        LogHelper::send_notification_FCM($user_from,translateNotification(__('notification.title.transaction_cancelled')), translateNotification(__('notification.transaction_cancelled')), $user_to->id, 'transaction', $user_from_type);
                    }
                }

                $response = [
                    'result'    => TRUE,
                    'message'   =>translateMessage('messages.status_updated'),
                ];
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.transaction_not_found'),
                ];
                $responseCode = 404;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function updateOrder($id, Request $request)
    {

	$validator = Validator::make($request->all(), [
          //  'status_id'         => 'required',
          //  'agreed_fee'        => 'numeric',
          //  'proof_img'         => 'image',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.fail_to_update'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            if(!empty($request->order_id)){
                $id = $request->order_id;
            }
           $order = Order::find($id);
        

	 if ($order) {
                $verified = true;

                // Check Transaction
                if (isset($request->status_id) && ($request->status_id == 3 || $request->status_id == 4)) {
                    $verified = OrderController::checkPaymentVerification($order);
                }

                if (!$verified && $order->status_id != $request->input('status_id')) {
                    $response = [
                        'result'    => FALSE,
                        'message'   =>translateMessage('messages.unverified_payment'),
                    ];
                } else {
                    if ($order->status_id == '4' || $order->status_id == '5') {
                        $responseCode = 400;
                        $response = [
                            'result'    => FALSE,
                            'message'   =>translateMessage('messages.order_cannot_changed') . ucwords($order->status->name),
                        ];
                    } 
                    else {
                        $error = false;
                        if (!empty($request->expiry_date) && ($request->input('status_id') == 1 || $request->input('status_id') == 2)) {
                            $date = Carbon::parse($request->expiry_date);
                            $today = Carbon::now();
                            if ($date < $today) {
                                $error = true;
                                if($request->ajax()){
                                    $response = [
                                        'result'    => FALSE,
                                        'message'   =>translateMessage('messages.expiry_date_less'),
                                    ];
                                    $responseCode = 200;
                                    return response()->json($response, $responseCode);
                                }else{
                                    $message =translateMessage('messages.expiry_date_less');
                                    $request->session()->flash('error', true);
                                }
                            }
                        }

                        if (!$error) {
                            $customer = Customer::find($order->customer_id);
  
                            if ($order->status_id != $request->status_id) {
                                $status = Status::find($request->status_id);
                                LogHelper::send_notification_FCM($customer, translateNotification(__('notification.title.order_updated')), translateNotification(__('notification.order_updated',['order_no' => changeToArabicDigits($order->order_no),'name' => ucwords($status->name)])), $order->id, 'order', 'customer');
                            }
                            $order->status_id       = $request->input('status_id');


                            // update transactions
                            if ($order->agreed_fee != $request->agreed_fee) {
                                LogHelper::send_notification_FCM($customer, translateNotification(__('notification.title.order_updated')), translateNotification(__('notification.order_updated_with_fee',['order_no' => changeToArabicDigits($order->order_no),'fee' => changeToArabicDigits($request->agreed_fee)])), $order->id, 'order', 'customer');

                                $transactions            = Transaction::where('order_id', $order->id)->get();
                                
				foreach ($transactions as $transaction) {
                                    $transaction->amount = $request->agreed_fee;
                                    $transaction->save();

                                    ////////////////// update amounnt in wallet
                                    $wallets = Wallet::where('transaction_id', $transaction->id)->get();
                             
					 foreach ($wallets as $wallet) {
                                        $wallet->amount = ($wallet->amount < 0) ? '-' . $request->agreed_fee : $request->agreed_fee;
                                        $wallet->save();
                                    }
                                }
                            }

                            if ($request->hasFile('proof_img')) {
                                $file_name = $order->order_no . "." . $request->proof_img->getClientOriginalExtension();
                                $request->proof_img->move(public_path('images_orders'), $file_name);
                                $order->proof_img = $file_name;
                            }
                            $order->agreed_fee = $request->input('agreed_fee');
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

                            $response = [
                                'result'    => TRUE,
                                'message'   =>translateMessage('messages.order_updated'),
                            ];
                        }
                    }
                }
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.order_not_found'),
                ];
                $responseCode = 404;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'user_type' => 'required',
            'order_id'  => 'required',
            'message'   => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.fail_to_update'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $message = new Message();
            $message->order_id  = $request->input('order_id');
            $message->message   = $request->input('message');
            $message->user_id   = $request->input('user_id');
            $message->user_type = ($request->user_type === 'admin') ? 'App\User' : "App\Customer";
            $message->save();

            // send notification to order customer.
            if ($request->user_type === 'admin') {
                $user = Customer::find($message->order->customer_id);
                LogHelper::send_notification_FCM($user, translateNotification(__('notification.title.new_message')), translateNotification(__('notification.new_message',['order_no' => changeToArabicDigits($message->order->order_no)])), $message->order_id, 'new_message', 'customer');
            } else {
                $admins = User::all();
                foreach ($admins as $admin) {
                    LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.new_message')), translateNotification(__('notification.new_message',['order_no' => changeToArabicDigits($message->order->order_no)])), $message->order_id, 'new_message');
                }
            }

            $response = [
                'result'    => TRUE,
                'message'   =>translateMessage('messages.notification_sent'),
            ];
        }
        return response()->json($response, $responseCode);
    }

    public function fetchMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_type' => 'required',
            'order_id'  => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.failed'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $order = Order::find($request->input('order_id'));
            // check all as read message.
            $user_type = ($request->user_type === 'admin') ? "App\Customer" : "App\Admin";
            $order->changeMessageAsRead($user_type);

            $results = DB::select('SELECT messages.*, users.name, users.email, users.avatar, customers.first_name, customers.last_name from messages
            LEFT JOIN users on users.id = messages.user_id
            LEFT JOIN customers on customers.id = messages.user_id
            WHERE order_id = :order_id ORDER BY created_at ASC', ['order_id' => $request->input('order_id')]);

            $response = [
                'result'    => TRUE,
                'data'      => $results,
            ];
        }

        return response()->json($response, $responseCode);
    }
}
