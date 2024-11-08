<?php

namespace App\Http\Controllers;

use App\Customer;
use App\DataTables\CustomersDataTable;
use App\Log;
use LogHelper;
use App\NumberChangeRequest;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class CustomerController extends Controller
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
    public function index(CustomersDataTable $dataTable)
    {
        
        $customers = Customer::withCount(['wallet as balance' => function ($q1) {
            $q1->select(DB::raw("IFNULL(SUM(amount), 0) as balance"))->where('user_type', 'App\Customer');
        }]) ->withCount('orders as all_orders')->withCount('transactionDetail as transactionDetail')->get();
   
    return view('dashboard.customers.index', ['customers' => $customers]);
        // return $dataTable->render('dashboard.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.customers.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'    => 'required|min:1',
            'last_name'     => 'required|min:1',
            'phone_no'      => 'required|min:1',
        ]);

        $data = $request->all();
        unset($data['_token']);
        $customer_exist = Customer::where('phone_no', $validatedData['phone_no'])->first();
        if (!$customer_exist) {
            $data['verified'] = 'true';
            $customer = Customer::create($data);
            //$customer->account_no   = $customer->generateAccountNumber();
            $customer->save();
            // $customer->account_no = "ACC-".$customer->id;
            $customer->account_no = $customer->id;
            $customer->update();
            $message =  translateMessage('messages.customerCreated');
        } else {
            $message = translateMessage('messages.customerAlreadyExist');
        }
        $request->session()->flash('message', $message);
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    public function customerRequests()
    {
        $requests = NumberChangeRequest::get();
        return view('dashboard.customers.requests', ['requests' => $requests]);
    }

    public function changeRequestStatus($id, $status, Request $request)
    {
        $message = "";
        $req = NumberChangeRequest::find($id);
        if ($req) {
            $req->status = $status;
            $req->save();

            if ($status === 'Approved') {
                if ($req->user_type === 'App\User') {
                    $user = User::find($req->user_id);
                } else {
                    $user = Customer::find($req->user_id);
                }
                if ($user) {
                    $user->phone_no = $req->new_number;
                    $user->save();

                    LogHelper::send_notification_FCM($user, translateNotification(__('notification.title.request_approved')), translateNotification(__('notification.change_status',['phone_no' => changeToArabicDigits($user->phone_no)])), $user->id, 'number_change_approved', 'customer');
                    $message =translateMessage('messages.statusChange');
                } else {
                    $message =translateMessage('messages.userNotFound');
                }
            } else {
                $message =translateMessage('messages.statusChange');
            }
        } else {
            $message =translateMessage('messages.recordNotFound');
        }
        $request->session()->flash('message', $message);

        $requests = NumberChangeRequest::paginate(20);
        return redirect()->route('customer.requests')->with(['requests' => $requests]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('dashboard.customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'first_name'    => 'required|min:1|max:64',
            'last_name'     => 'required|min:1|max:64',
            'cnic'          => 'required|min:1|max:64',
            'nationality'   => 'required|min:1|max:64',
            'gender'        => 'required|min:1|max:64',
            'phone_no'      => 'required|min:1|max:64',
        ]);

        $customer->first_name   = $request->input('first_name');
        $customer->last_name    = $request->input('last_name');
        $customer->email        = $request->input('email');
        $customer->cnic         = $request->input('cnic');
        $customer->gender       = $request->input('gender');
        $customer->phone_no     = $request->input('phone_no');
        $customer->nationality  = $request->input('nationality');
        $customer->address      = $request->input('address');
        $customer->save();
        $request->session()->flash('message',translateMessage('messages.customer_updated'));
        return redirect()->route('customers.index');
    }


    public function logReport()
    {
        $customers = Customer::all();
        // return $customers[5];
        return view('dashboard.customers.logreport', ['customers' => $customers]);
    }

    public function fetchLogReport()
    {
        $start_date = (!empty($_GET["start_date"])) ? ($_GET["start_date"]) : ('');
        $end_date = (!empty($_GET["end_date"])) ? ($_GET["end_date"]) : ('');
        $user_id = (!empty($_GET["user_id"])) ? ($_GET["user_id"]) : ('');
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));

        if(!empty($user_id)){
            $logs = Log::with('relatedUser')
            ->where('user_id', $user_id)
            ->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
        }else{
            $logs = Log::with('relatedUser');
        }

        return DataTables::of($logs)
            ->addColumn('full_name', function ($row) {
                return !empty($row->user) ? ($row->user->first_name . " " . $row->user->last_name) : '';
            })
            ->editColumn('action', function ($row) {
                // return !empty($row) ? (  translateMessage('customer.'.$row->action) ): '';

                $str =$row->action;
              
                $kept = explode( '.', $str,2);
                $data=  translateMessage('customer.'.$kept[0]).' '.$kept[1];
                $d=explode( '(', $str,2);
                if ( $d[0] == "User transferred balance" ) {
                   $d2 =explode( '.',$d[1],2);
                    $toAdmin=  substr($d2[0],strpos($d2[0], ')'),+ 20);
                   
                   $data= translateMessage('customer.'.$d[0]).'('.((explode( ')',$d[1],2))[0]).')'. translateMessage('customer.'.$toAdmin);
                }
                return $data;
                // $data=  !empty($row) ? $row->action : '';
                //  return $data;
                })
            ->editColumn('created_at', function ($row) {
           
                // $date = Carbon::parse($row->created_at);
                // $date->format('Y-m-d h:i:s A');
             
                // return  $date->isoFormat('Y-m-d h:mm:s a');
             
                // $time = date('h:i:s',strtotime($row->created_at));
                // $convertedtime = Carbon::parse($time)->isoFormat('h:mm a');
                // return date('Y-m-d ', strtotime($row->created_at)). $convertedtime;
                return date('Y-m-d h:i:s A', strtotime($row->created_at));
            })
            ->filterColumn('full_name', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%');
                    $q->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            })
            
    
            ->addIndexColumn()
            
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, Request $request)
    {
        $message = "";
        if ($customer) {
            $transactions = Transaction::where('from_acc_id', $customer->account_no)->orWhere('to_acc_id', $customer->account_no)->get();
            if (count($customer->orders) > 0 || count($transactions) > 0) {
                $message =translateMessage('messages.customerCannotDelete');
            } else {
                $customer->delete();
                $message = translateMessage('messages.customerDelete');
            }
        }
        $request->session()->flash('message', $message);
        return redirect()->route('customers.index');
    }
}
