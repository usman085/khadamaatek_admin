<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DataTables\TransactionsDataTable;
use App\Transaction;
use App\User;
use App\Wallet;
use LogHelper;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionsDataTable $dataTable)
    {
        // $transactions = Transaction::with('from_customer')->with('to_customer')->with('from_user')->with('to_user')->paginate('20');
        // return view('dashboard.transactions.index', compact('transactions'));
        return $dataTable->render('dashboard.transactions.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('dashboard.transactions.edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            // 'amount'            => 'required|numeric',
            'status'            => 'required',
        ]);

        if ($transaction) {
            // $transaction->amount            = $request->amount;
            $transaction->status            = $request->status;
            $transaction->save();

            $wallets    = Wallet::where('transaction_id', $transaction->id)->get();
            if (count($wallets) > 0) {
                foreach ($wallets as $wallet) {
                    $wallet->delete();
                }
            }

            // From User
            if ($transaction->from_type === 'App\User') {
                $user_from  = User::where('account_no', $transaction->from_acc_id)->first();
            } else {
                $user_from  = Customer::where('account_no', $transaction->from_acc_id)->first();
            }
            // To User
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

                if ($transaction->etype != 'bankTransfer') {
                    // To Transaction

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
            $request->session()->flash('message', translateMessage("messages.transactionStatusUpdate"));
        } else {
            $request->session()->flash('message',translateMessage("messages.transactionNotExist") );
        }
        return redirect()->route('transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction, Request $request)
    {
        if ($transaction) {
            $wallets    = Wallet::where('transaction_id', $transaction->id)->get();
            if (count($wallets) > 0) {
                foreach ($wallets as $wallet) {
                    $wallet->delete();
                }
            }

            $transaction->delete();
            $response_message = translateMessage("message.transactionDelete");
        } else {
            $response_message = translateMessage("message.transactionNotFound");
        }
        $request->session()->flash('message', $response_message);
        return redirect()->route('transaction.index');
    }
}
