<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Document;
use App\CustomerDocument;
use App\Http\Controllers\Controller;
use App\Mail\NotificationEmail;
use App\Mail\VerifyMail;
use App\Message;
use App\Order;
use App\Service;
use App\Requirement;
use App\Transaction;
use App\User;
use App\VerifyCustomer;
use App\Wallet;
use LogHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use function Opis\Closure\serialize;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $data = $request->validate([
            'first_name'    => 'required|min:1',
            'cnic'          => 'required|min:1',
            'phone_no'      => 'required|min:1',
        ]);

        $customer_exist = Customer::where('phone_no', $data['phone_no'])->first();

        if (!$customer_exist) {
            $customer = new Customer();
            $customer->first_name       = $request->first_name;
            $customer->last_name        = $request->last_name;
            $customer->email            = $request->email;
            $customer->cnic             = $request->cnic;
            $customer->nationality      = $request->nationality;
            $customer->gender           = $request->gender;
            $customer->phone_no         = $request->phone_no;
            $customer->address          = $request->address;
            $customer->verified         = 'true';
            $customer->account_no       = $customer->generateAccountNumber();
            $customer->save();

            $response = [
                'result'    => TRUE,
                'message'   =>translateMessage('messages.customer_created'),
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.customer_already_registered'),
            ];
            $responseCode = 500;
        }

        return response()->json($response, $responseCode);
    }

    public function getWalletBalance(Request $request)
    {
        if (!$request->user_id) {
            $response = [
                'result'        => FALSE,
                'message'       =>translateMessage('messages.customer_is_missing'),
            ];
            $responseCode = 500;
        } else {
            $user       = Customer::find($request->user_id);
            $balance    = Wallet::where(['user_id' => $request->user_id, 'user_type' => "App\Customer"])->sum('amount');
            $response = [
                'result'        => TRUE,
                'currency'      => "SAR:",
                'data'          =>
                [
                    'unread_messages'   => $user->notifications->where('is_read', 0)->count(),
                    'balance'           => $balance,
                    'user'              => $user,
                ]
            ];
            $responseCode = 200;
        }

        return response()->json($response, $responseCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
       
        if ($request->user_type === 'admin') {
            $user = User::where('id', $id)->orWhere('phone_no', $id)->with(['requests' => function ($q) {
                $q->orderBy('id', 'desc')->first();
            }])->first();
        } else {
            $user = Customer::where('id', $id)->orWhere('phone_no', $id)->with(['requests' => function ($q) {
                $q->orderBy('id', 'desc')->first();
            }])->first();
        }
        if ($user) {
            $user->status = ['Pending', 'Approved', 'Cancelled'];
            $response = [
                'result'    => TRUE,
                "message"   =>translateMessage('messages.user_profile'),
                'user'      => $user,
            ];
            $reponsecode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.user_not_found'),
            ];
            $reponsecode = 404;
        }

        return response()->json($response, $reponsecode);
    }

    public function bankTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'   => 'required',
            'etype'         => 'required',
            // 'account_num'   => 'required',
            // 'sort_code'     => 'required',
            'amount'        => 'required|numeric',
            'deposit_slip'  => 'required|image',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.failed_to_save'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $user_from = User::find(1);
            $user_to = Customer::find($request->customer_id);

            $transaction = new Transaction();
            $transaction->from_acc_id       = $user_to->account_no;
            $transaction->from_bank_accno   = $user_to->account_no;

            $transaction->to_acc_id         = $user_from->account_no;
            $transaction->to_type           = "App\User";
            // $transaction->to_bank_name      = $request->account_title;
            // $transaction->to_bank_accno     = $request->account_num;
            // $transaction->sort_code         = $request->sort_code;
            $transaction->amount            = $request->amount;
            $transaction->etype             = $request->etype;

            $file = $request->file('deposit_slip');
            if ($file) {
                $file_name      = "slip" . "-" . time() . '.' . $file->extension();
                $request->deposit_slip->move(public_path('transactions'), $file_name);
                $transaction->attachment   = $file_name;
            }

            $transaction->save();

            LogHelper::store($user_to->id, "User transferred balance({$request->amount}) to admin account.");
            $admins = User::all();
            foreach ($admins as $admin) {
                LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.deposit_balance')), translateNotification(__('notification.deposit_balance_new',['first_name' => $user_to->first_name,'last_name' => $user_to->last_name,'amount' => changeToArabicDigits($request->amount)])), $user_to->id, 'transaction');
            }

            $this->sendOrderNotificationMail($user_to, 'deposit');

            // $transaction = new Transaction();
            // $transaction->from_acc_id       = $user_from->account_no;
            // $transaction->from_type         = "App\User";
            // $transaction->from_bank_name    = $request->account_title;
            // $transaction->from_bank_accno   = $request->account_num;

            // $transaction->to_acc_id         = $user_to->account_no;
            // $transaction->to_bank_accno     = $user_to->account_no;
            // $transaction->sort_code         = $request->sort_code;
            // $transaction->amount            = $request->amount;
            // $transaction->etype             = 'balanceShare';
            // $transaction->save();

            $response = [
                'result'        => TRUE,
                'message'       =>translateMessage('messages.amount_transfered'),
                // 'transaction' => $transaction
            ];
            $responseCode = 200;
        }

        return response()->json($response, $responseCode);
    }

    public function balanceShare(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'phone_no'    => 'required',
            'etype'             => 'required',
            'amount'            => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.failed_to_save'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } 
        else {
            // check user wallet balance
            $user_from       = $request->user();
    
            $balance    = Wallet::where(['user_id' => $user_from->id, 'user_type' => "App\Customer"])->sum('amount');

         $user_to    = Customer::where('phone_no', $request->phone_no)->first();
     	 if ($request->phone_no != $user_from->phone_no  ) {
               if ($user_to != null) {
                        if ($balance >= $request->amount) {
                            $transaction = new Transaction();
                            $transaction->from_type         = "App\Customer";
                            $transaction->from_acc_id       = $user_from->account_no;
                            $transaction->from_bank_accno   = $user_from->account_no;
                            $transaction->to_type           = "App\Customer";
                            $transaction->to_acc_id         = $user_to->account_no;
                            $transaction->to_bank_accno     = $user_to->account_no;
                            $transaction->amount            = $request->amount;
                            $transaction->status            = "Verified";
                            $transaction->etype             = $request->etype;
                            $transaction->save();
                            if ($transaction->etype === 'balanceShare') {
                                /**
                                 * A Transaction will be created against them who will recieved payment
                                 */
                                
                                $transaction_reciever = new Transaction();
                                $transaction_reciever->from_type         = "App\Customer";
                                $transaction_reciever->from_acc_id       = $user_to->account_no;
                                $transaction_reciever->from_bank_accno   = $user_to->account_no;
                                $transaction_reciever->to_type           = "App\Customer";
                                $transaction_reciever->to_acc_id         = $user_from->account_no;
                                $transaction_reciever->to_bank_accno     = $user_from->account_no;
                                $transaction_reciever->amount            = $request->amount;
                                $transaction_reciever->status            = "Verified";
                                $transaction_reciever->etype             = "balanceReceived";
                                $transaction_reciever->save();
                            }

                            if ($transaction->etype != 'bankTransfer') {

                                // From Transaction
                                $wallet = new Wallet();
                                $wallet->user_type      = $transaction->from_type;
                                $wallet->user_id        = $user_from->id;
                                $wallet->transaction_id = $transaction->id;
                                $wallet->amount         = ($transaction->etype !== 'bankTransfer') ?  '-' . $transaction->amount : $transaction->amount;
                                $wallet->save();
                                // To Transaction

                                $to_wallet = new Wallet();
                                $to_wallet->user_type       = $transaction->to_type;
                                $to_wallet->user_id         = $user_to->id;
                                $to_wallet->amount          = $transaction->amount;
                                $to_wallet->transaction_id  = $transaction->id;
                                $to_wallet->save();
                            }else{
                                $response = [
                                    'result'        => FALSE,
                                    'message'       =>translateMessage('messages.transaction_type_not_supported'),
                                ];
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
                                    LogHelper::send_notification_FCM($user_from, translateNotification(__('notification.title.transaction_approved')), translateNotification(__('notification.balance_transferred',['amount' => changeToArabicDigits($transaction->amount),'account_no' => changeToArabicDigits($transaction->to_acc_id)])), $user_to->id, 'transaction', $user_from_type);

                                    // User To
                                    LogHelper::send_notification_FCM($user_to, translateNotification(__('notification.title.transaction_approved')), translateNotification(__('notification.balance_recieved',['amount' => changeToArabicDigits($transaction->amount),'account_no' => changeToArabicDigits($transaction->from_acc_id)])), $user_from->id, 'transaction', $user_to_type);
                                } else {
                                    // User From
                                    LogHelper::send_notification_FCM($user_from, translateNotification(__('notification.title.transaction_cancelled')),  translateNotification(__('notification.transaction_cancelled')), $user_to->id, 'transaction', $user_from_type);
                                }
                            }

                            $response = [
                                'result'        => TRUE,
                                'message'       => translateNotification(__('notification.balance_recieved',[
                                                                                                            'amount' => changeToArabicDigits($transaction->amount),
                                                                                                            'account_no' => changeToArabicDigits($transaction->to_acc_id)
                                                                                                            ])),
                            ];

                            // LogHelper::store($user->id, "User shared balance({$request->amount}) to Account No.{$request->to_account_num}.");
                            // $admins = User::all();
                            // foreach ($admins as $admin) {
                            //     LogHelper::send_notification_FCM($admin, "Transfer Balance", "{$user->first_name} {$user->last_name} transferred balance({$request->amount}) to Account No.{$request->to_account_num}.", $user->id, 'transaction');
                            // }

                            // $response = [
                            //     'result'        => TRUE,
                            //     'message'       => "Amount will be transfered to Account#{$transaction->to_acc_id} after admin verification.",
                            // ];
                            $responseCode = 200;
                        } else {
                            $response = [
                                'result'        => FALSE,
                                'message'       =>translateMessage('messages.wallet_amount_insufficient'),
                            ];
                            $responseCode = 500;
                        }
                    } 
                    else {
                        $response = [
                            'result'        => FALSE,
                            'message'       =>translateMessage('messages.user_account_not_found'),
                        ];
                        $responseCode = 404;
                    }
            }
            else {
                $response = [
                    'result'        => FALSE,
                    'message'       =>translateMessage('messages.you_can_not_transfer_on_your_own_number'),
                ];
                $responseCode = 401;
            }
                return response()->json($response, $responseCode);
            }
          }
          


    public function cancelOrder($order_id, $customer_id = 0)
    {
        $order = Order::find($order_id);
        if ($order) {
            $order->status_id = 5;
            $order->save();

            // change transaction status and remove wallet balance from admin
            $transaction = Transaction::where('order_id', $order->id)->first();
            $transaction->status = 'Cancelled';
            $transaction->save();

            $wallets = Wallet::where('transaction_id', $transaction->id)->get();
            foreach ($wallets as $wallet) {
                $wallet->delete();
            }

            // Save log
            LogHelper::store($order->customer->id, "User cancelled order No.{$order->order_no}.");
            $admins = User::all();
            foreach ($admins as $admin) {
                LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.order_cancelled')), translateNotification(__('notification.deposit_balance',['first_name' => $order->customer->first_name,'last_name' => $order->customer->last_name,'order_no' => changeToArabicDigits($order->order_no)])), $order->customer->id, 'order');
            }
            $response = [
                'result'    => TRUE,
                "message"   =>__('messages.order_canceled'),
            ];
            $reponsecode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.order_not_found'),
            ];
            $reponsecode = 404;
        }

        return response()->json($response, $reponsecode);
    }

    public function verifyEmailSend($id, Request $request)
    {
        if ($request->user_type && $request->user_type == 'admin') {
            $user = User::find($id);
        } else {
            $user = Customer::find($id);
        }
        if ($user) {
            $verifyUser = VerifyCustomer::create([
                'user_id'   => $user->id,
                'user_type' => ($request->user_type && $request->user_type == 'admin') ? 'App\User' : "App\Customer",
                'token'     => sha1(time()),
            ]);
            Mail::to($user->email)->send(new VerifyMail($user, $verifyUser->token));

            $response = [
                'result'    => TRUE,
                "message"   =>translateMessage('messages.please_verify_email'),
            ];
            $reponsecode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.user_not_found'),
            ];
            $reponsecode = 404;
        }

        return response()->json($response, $reponsecode);
    }

    public function verifyCustomerEmail($user_type, $token, Request $request)
    {
        $verifyUser = VerifyCustomer::where('token', $token)->first();
        $token_time = Carbon::parse($verifyUser->created_at);
        $current_time = new Carbon();
        $totalMinutes = $current_time->diffInMinutes($token_time);

        if (isset($verifyUser) && !empty($verifyUser)) {
            if ($user_type === 'admin') {
                $user = $verifyUser->user;
            } else {
                $user = $verifyUser->customer;
            }

            if ($user->email_verified_at) {
                $response = [
                    'result'    => TRUE,
                    "message"   =>translateMessage('messages.email_already_verified'),
                ];
            } else {
                if ($totalMinutes > 30) {
                    $response = [
                        'result'    => FALSE,
                        "message"   => translateMessage('messages.token_expire'),
                    ];
                } else {
                    $user->email_verified_at = date('Y-m-d H:i:s');
                    $user->save();

                    LogHelper::store($user->id, "User Email verified.", $user_type);

                    $response = [
                        'result'    => TRUE,
                        "message"   =>translateMessage('messages.verified_successfully'),
                    ];
                }
            }
            $verifyUser->update([
                'created_at'    =>   Carbon::parse($verifyUser->created_at)->addMinutes(30)
            ]);
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.email_not_identified'),
            ];
        }
        // $request->session()->flash('verified_message', $response['message.');
        return redirect()->route('verify.message', ['message' => $response['message']]);
        // return response()->json($response, $reponsecode);
    }
    public function getPlaceOrderDetail(Request $request){
	  $validator = Validator::make($request->all(), [
            'order_id'     => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.order_id_required'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
  	$order = Order::find($request->order_id);
	 
	if(!empty($order->customer_requirement_data)){
    		$decode_data = json_decode($order->customer_requirement_data,true);
            	 $new_document_detail_data = [];
                foreach($decode_data as $key => $data){
	
          	$document_detail = $key;
              $document_detail_array = explode('_',$document_detail);
	
		  $document_detail_object = Document::find(end($document_detail_array));
                    if(empty($document_detail_object)){
                      $document_detail_object = Document::find($data);
                    }
                    if(!empty($document_detail_object)){
                        array_push($new_document_detail_data,[
			
                         'document_id' => $document_detail_object->id,
			]);
                    }
                }
	

	$new_document_detail_data = collect($new_document_detail_data)->pluck('document_id')->toArray();
	$data = json_decode($order->customer_req_doc_id,true);
	$doc_save_name =[];

	
	
	
             $service = Service::where('id', $order->service_id)->first();
       	    $documents = Document::whereIn('id',getDocumentListArray($service->formbuilder_id))->get();
                $customer_documents = [];
                if ($service) {
                    foreach ($documents as $key => $doc) {
                        $customer_documents[$key]['flag']  = FALSE;
                        if(in_array($doc->id,$new_document_detail_data)){
                            $customer_documents[$key]['flag']  = TRUE;
                        }

                        $customer_documents[$key]['label']  = $doc->name;
                        $customer_documents[$key]['document_type']  = $doc->document_type;
                        $customer_documents[$key]['document_id']    = $doc->id;
			if(  $customer_documents[$key]['flag']  == FALSE){
			$customer_documents[$key]['save_req_doc_name']    =null;
			$customer_documents[$key]['save_req_doc_id'] =null;
			}
			else{
				if($data){
			foreach($data  as $d){
		$req_name =CustomerDocument::where('id',$d)->where('document_id',$doc->id)->first();
		if($req_name['name'] !=null){
		$customer_documents[$key]['save_req_doc_name'] = $req_name['name'];
		$customer_documents[$key]['save_req_doc_id'] = $req_name['id'];

		}
			}
	}	
			}
                        $customer_documents[$key]['data']           = CustomerDocument::where(['document_id' => $doc->id, 'user_id' => $order->customer_id])->get();
                    }
                }
		//return $doc_save_name;
                $order->required_documents = $customer_documents;
            }
            $response = [
                'result'    => TRUE,
                'message'   => "",
                'order'     => $order,
            ];
            $responseCode = 200;
        }

        return response()->json($response, $responseCode);
    }

    public function updateOrder(Request $request)
    {
	$validator = Validator::make($request->all(), [
           'order_id'            => 'required',
            'customer_requirement_data'       => 'required',
        ]);
	
        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => translateMessage('messages.failed_to_update'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $order = Order::find($request->order_id);
            $balance = Wallet::where(['user_id' => $order->customer_id, 'user_type' => "App\Customer"])->sum('amount');
          $customer = Customer::find($order->customer_id);
           
 	//response()->json( $customer,200);
	 // Check wallet balance
            if ($balance >= $order->agreed_fee) {
                $order->customer_requirement_data = !empty($request->customer_requirement_data) ? $request->customer_requirement_data : $order->customer_requirement_data;
           	$order->customer_req_doc_id= json_encode($request->customer_req_doc_id,true);
      
	  	$order->save();
                // $this->sendOrderNotificationMail($order);
                LogHelper::store($order->customer_id, "User update service order. Order No.{$order->order_no}");

                $admins = User::all();
                foreach ($admins as $admin) {
                    LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.update_order')), translateNotification(__('notification.update_order',['order_no' => changeToArabicDigits($order->order_no)])), $customer->id, 'order');
                }

                $response = [
                    'result'    => TRUE,
                    'message'   =>translateMessage('messages.order_updated'),
                    'order'     => $order,
                ];
                $responseCode = 200;
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.insufficient_balance'),
                ];
                $responseCode = 200;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function placeOrder(Request $request)
    {       
	//return $request->all();
	 $validator = Validator::make($request->all(), [
           'customer'            => 'required',
          'selectedGroup'       => 'required',
           'selectedDept'        => 'required',
          'selectedCat'         => 'required',
          'selectedService'     => 'required',
           'selectedServiceFee'  => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.failed_to_save'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
       $balance = Wallet::where(['user_id' => $request->customer, 'user_type' => "App\Customer"])->sum('amount');
            $customer = Customer::find($request->customer);
            // Check wallet balance
            if ($balance >= $request->selectedServiceFee) {
	
                $order = new Order();
                $order->customer_id     = $request->customer;
                $order->group_id        = $request->selectedGroup;
                $order->department_id   = $request->selectedDept;
                $order->service_id      = $request->selectedService;
                $order->agreed_fee      = $request->selectedServiceFee;
                $order->order_date      = date('Y-m-d H:i:s');
               $order->customer_requirement_data = $request->customer_requirement_data;
                 $order->customer_req_doc_id= json_encode($request->customer_req_doc_id,true);
		//return json_encode($request->customer_req_doc_id,true);
		if($request->selectedSubCats){
                $subcats                = $request->selectedSubCats;
                $total_subcats          = count($subcats);
		}
		else{ $total_subcats = 0;}
                if ($total_subcats > 0) {
                    $order->category_id     = $subcats[$total_subcats - 1];
                    array_unshift($subcats, $request->selectedCat);
                    $order->cat_ids         = serialize($subcats);
                } else {
                    $order->category_id     = $request->selectedCat;
                }
                $order->order_no = $order->generateOrderNumber();
                $order->save();

                $this->orderTransaction($request->customer, $order);

                $this->sendOrderNotificationMail($order);

                LogHelper::store($request->customer, "User placed a new service order. Order No.{$order->order_no}");

                $admins = User::all();
                foreach ($admins as $admin) {
                    LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.new_order')), translateNotification(__('notification.new_order',['order_no' => changeToArabicDigits($order->order_no)])), $customer->id, 'order');
                }

                $response = [
                    'result'    => TRUE,
                    'message'   =>translateMessage('messages.order_placed'),
                    'order'     => $order,
                ];
                $responseCode = 200;
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.insufficient_balance'),
                ];
                $responseCode = 200;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function orderTransaction($customer_id, $order)
    {
        $customer   = Customer::find($customer_id);
        $from_type  = 'App\Customer';
        $admin      = User::find(1);
        $to_type    = 'App\User';

        $transaction = new Transaction();
        $transaction->from_acc_id       = $customer->account_no;
        $transaction->from_bank_accno   = $customer->account_no;
        $transaction->from_type         = $from_type;
        $transaction->to_acc_id         = $admin->account_no;
        $transaction->to_bank_accno     = $admin->account_no;
        $transaction->to_type           = $to_type;
        $transaction->amount            = $order->agreed_fee;
        $transaction->order_id          = $order->id;
        $transaction->status            = 'Verified';
        $transaction->etype             = 'order';
        $transaction->save();

        // Wallet Transfer Data
        // From account
        $wallet = new Wallet();
        $wallet->user_type      = $from_type;
        $wallet->user_id        = $customer->id;
        $wallet->transaction_id = $transaction->id;
        $wallet->amount         = '-' . $transaction->amount;
        $wallet->save();

        // To Account
        $to_wallet = new Wallet();
        $to_wallet->user_type       = $to_type;
        $to_wallet->user_id         = $admin->id;
        $to_wallet->amount          = $transaction->amount;
        $to_wallet->transaction_id  = $transaction->id;
        $to_wallet->save();
    }

    public function sendOrderNotificationMail($data, $type = 'order')
    {
        $admin = User::find(1);
        Mail::to($admin->email)->send(new NotificationEmail($data, $type));
        return 'Email sent Successfully';
    }

    public function saveRequirementData(Request $request)
    {
        $data = $request->except('_token');
        $schemaModel = [];
        $i = 1;
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                if ($file) {
                    $fileName = "attachment-" . $i . "-" . time() . '.' . $file->extension();
                    $request->$key->move(public_path('requirements_attach'), $fileName);
                    $schemaModel[$key] = $fileName;
                }
            } else {
                if (strpos($key, '-type') === false) {
                    if (isset($data[$key . '-type']) && $data[$key . '-type'] === 'date') {
                        $schemaModel[$key] = "dateTimeStamp-" . $value;
                    } else {
                        $schemaModel[$key] = $value;
                    }
                }
            }
            $i++;
        }

        $reqData = new Requirement();
        $reqData->order_id = $request->order_id;
        $reqData->dataModel = json_encode($schemaModel);
        $reqData->save();

        $response = [
            'result'    => true,
            'message'   =>translateMessage('messages.requirement_saved'),
        ];
        $responseCode = 200;

        return response()->json($response, $responseCode);
    }

    public function saveDocumentData(Request $request)
    {
        $responseCode = 200;

        $validator = Validator::make($request->all(), [
            'document_id'   => 'required',
            'document_name' => 'required|unique:customer_documents,name,' . $request->selectedSavedDoc . ',id,user_id,' . $request->user_id,
            'user_id'       => 'required',
            'user_type'     => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.failed_to_save'),
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $data = $request->except('_token');
            $schemaModel = [];
            $i = 1;
            foreach ($data as $key => $value) {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    if ($file) {
                        $fileName = "attachment-" . $i . "-" . time() . '.' . $file->extension();
                        $request->$key->move(public_path('customer_documents'), $fileName);
                        $schemaModel[$key] = $fileName;
                    }
                } else {
                    if (strpos($key, '-type') === false) {
                        if (isset($data[$key . '-type']) && $data[$key . '-type'] === 'date') {
                            $schemaModel[$key] = "dateTimeStamp-" . $value;
                        } else {
                            $schemaModel[$key] = $value;
                        }
                    }
                }
                $i++;
            }

            if ($request->selectedSavedDoc) {
                $doc = CustomerDocument::find($request->selectedSavedDoc);
            } else {
                $doc = new CustomerDocument();
            }

            $doc->name = $request->document_name;
            $doc->user_id = $request->user_id;
            $doc->user_type = ($request->user_type === 'customer') ? "App\Customer" : "App\User";
            $doc->document_id = $request->document_id;
            $doc->dataModel = json_encode($schemaModel);
            $doc->save();

            $response = [
                'result'    => true,
                'message'   =>translateMessage('messages.document_saved'),
                'document'  => $doc,
            ];
        }

        return response()->json($response, $responseCode);
    }


    public function walletHistory($customer_id)
    {
        if (!$customer_id) {
            $response = [
                'result'    => FALSE,
                'message'   =>translateMessage('messages.customer_missing'),
            ];
            $responseCode = 400;
        } else {
            $customer  = Customer::find($customer_id);
            if ($customer) {
                $transactions = Transaction::select('amount', 'status', 'created_at as transaction_date')
                    ->where(['from_acc_id' => $customer->account_no, 'etype' => 'bankTransfer'])
                    ->get();

                $response = [
                    'result'        => TRUE,
                    "message"       =>translateMessage('messages.transaction_found'),
                    'transactions'  => $transactions
                ];
                $responseCode = 200;
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   =>translateMessage('messages.customer_not_found'),
                ];
                $responseCode = 404;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function getOrderbyCustomer(Request $request)
    {
       
        $limit = 10;
        $offset=0;
        $filter_type = $request->filter;
        $customer_id = $request->id;
        if(isset($request->limit)){
            $limit = $request->limit;
        }
        if(isset($request->offset)){
            $offset = $request->offset;
        }
        // return  $limit;
        $countOrders = Order::where("customer_id", $customer_id)->get()->count();
        if ($customer_id) {
            if ($filter_type) {
                $orders = Order::where(["customer_id" => $customer_id, 'status_id' => $filter_type])
                    ->with('category')
                    ->with('department')
                    ->with('service')
                    ->with('group')
                    ->with('status');
            } else {
                $orders = Order::where("customer_id", $customer_id)
                    ->with('category')
                    ->with('department')
                    ->with('service')
                    ->with('group')
                    ->with('status')->skip($offset)->take($limit )->get();
            }

            if (count($orders) > 0) {
                foreach ($orders as $key => $value) {
                    $orders[$key]['unread_msg'] = $orders[$key]->getUnreadMessageCount('App\User');
                }

                return response()->json([
                    'result' => TRUE,
                    'message' =>translateMessage('messages.order_found'),
                    'orders' => $orders,
                    'total_orders' =>  $countOrders,
                ]);
            } else {
                return response()->json([
                    'result' => FALSe,
                    'message' =>translateMessage('messages.order_not_found'),
                ]);
            }
        } else {
            return response()->json([
                'result' => FALSE,
                'message' =>translateMessage('messages.customer_missing'),
            ], 500);
        }
    }

    public function getJsonOrder(Request $request){
        $order_id = $request->id;
        if ($order_id) {
            $order = Order::where("id", $request->id)
                        ->with('category')
                        ->with('department')
                        ->with('service')
                        ->with('status')->first();

            if ($order) {
                $order['unread_msg'] = $order->getUnreadMessageCount('App\User');
                return response()->json([
                    'result' => TRUE,
                    'message' =>translateMessage('messages.order_found'),
                    'order' => $order,
                ]);
            } else {
                return response()->json([
                    'result' => FALSe,
                    'message' =>translateMessage('messages.order_not_found'),
                ]);
            }
        } else {
            return response()->json([
                'result' => FALSE,
                'message' =>translateMessage('messages.order_id_missing'),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_method', 'user_type');
        $user = $request->user();
        if ($request->user_type === 'admin') {
            $file = $request->file('avatar');
            $imageName = "";
            if ($file) {
                $imageName      = "avatar" . "-" . time() . '.' . $file->extension();
                $request->avatar->move(public_path('assets/img/avatars'), $imageName);
            }

            $resp = $this->updateAdminUser($data, $user, $imageName);
        } else {
            $resp = $this->updateCustomer($data, $user);
        }

        return response()->json($resp[0], $resp[1]);
    }

    public function updateCustomer($request, $customer)
    {
        if ($customer && $customer->verified == 'true') {

            foreach ($request as $key => $value) {
                if ($key === 'email') {
                    if ($customer->email !== $request['email']) {
                        $customer->email_verified_at = NULL;
                    }
                }

                if (isset($request[$key])) {
                    $customer->$key = $value;
                }
            }
            $customer->save();

            $response = [
                'result'    => TRUE,
                "message"   =>translateMessage('messages.user_updated'),
                'user'      => $customer,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.profile_or_user_not_verified'),
            ];
            $responseCode = 404;
        }

        return [$response, $responseCode];
    }

    public function updateAdminUser($request, $user, $avatar = '')
    {
        if ($user) {
            if (isset($request['email'])) {
                $emailCheck = User::where('email', $request['email'])->first();
                if ($emailCheck) {
                    $response = [
                        'result'    => FALSE,
                        "message"   =>translateMessage('messages.email_exist'),
                    ];
                    $responseCode = 400;
                    return [$response, $responseCode];
                } else {
                    $user->email  = $request['email'];
                    $user->email_verified_at  = null;
                }
            }

            if (isset($request['phone_no'])) {
                $user->phone_no    = $request['phone_no'];
            }

            if (isset($request['name'])) {
                // $name = $request['first_name'];
                // if (isset($request['last_name'])) {
                //     $name .= ' ' . $request['last_name'];
                // }
                $user->name = $request['name'];
            }

            if ($avatar) {
                $user->avatar = $avatar;
            }

            $user->save();

            $response = [
                'result'    => TRUE,
                "message"   =>translateMessage('messages.user_updated'),
                'user'      => $user,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   => translateMessage('messages.user_not_found'),
            ];
            $responseCode = 404;
        }

        // $old_pass = $request->input('old_password');
        // $new_pass = $request->input('new_password');
        // if ($old_pass && $new_pass) {
        //     if (Hash::check($old_pass, $user->password)) {
        //         $user->password   = Hash::make($new_pass);
        //     } else {
        //         $request->session()->flash('message', 'Password does not match!!');
        //     }
        // }
        return [$response, $responseCode];
    }

    public function fetchMessages($id)
    {

        $order = Order::find($id);
        if ($order) {
            // check all as read message.
            $order->changeMessageAsRead('App\User');

            $results = DB::select('SELECT messages.*, DATE_FORMAT(messages.created_at, "%Y-%m-%d %r") as sent_at, users.name, users.email, users.avatar, customers.first_name, customers.last_name from messages
            LEFT JOIN users on users.id = messages.user_id
            LEFT JOIN customers on customers.id = messages.user_id
            WHERE order_id = :order_id ORDER BY created_at ASC', ['order_id' => $id]);

            $response = [
                'result'    => TRUE,
                "message"   => $results,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.orderNotFound'),
            ];
            $responseCode = 404;
        }

        return response()->json($response, $responseCode);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'order_id' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.msg_send_fail'),
            ];
            $responseCode = 400;
        } else {
            $message = new Message();
            $message->order_id = $request->order_id;
            $message->message = $request->message;
            $message->user_id = $request->user_id;
            $message->user_type = 'App\Customer';
            $message->save();

            $admins = User::all();
            foreach ($admins as $admin) {
                LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.new_message')), translateNotification(__('notification.new_message',['order_no' => changeToArabicDigits($message->order->order_no)])), $message->order_id, 'new_message');
            }

            return response()->json([
                'message' => "Note Sent successfully!",
            ]);
        }
        return response()->json($response, $responseCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
