<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\DataTables\CustomersDataTable;
use App\DataTables\UsersDataTable;
use App\Services\RolesService;
use App\Transaction;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.usersList');
    }

    public function create()
    {
        $roles  = RolesService::get();
        return view('dashboard.admin.userCreateForm', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'          => 'required|min:1|max:256',
            'email'         => 'required|email|max:256',
            'phone_no'      => 'required',
            'password'      => 'required|min:8|max:256'
        ]);

        $user = new User();
        $user->name                 = $request->input('name');
        $user->email                = $request->input('email');
        $user->phone_no             = $request->input('phone_no');
        $user->menuroles            = implode(",", $request->input('role'));
        $user->password             = Hash::make($request->input('password'));
        if(in_array('admin',$request->input('role'))){
            $user->email_verified_at    = date('Y-m-d H:i:s');
        }
        $user->save();

        $user->account_no           = $user->generateAccountNumber();
        $user->save();

        $request->session()->flash('message', translateMessage("messages.userCreated"));
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.admin.userShow', compact('user'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'image' => 'image',
        ]);
        $user           = auth()->user();
        if ($user->email !== $request->input('email')) {
            $user->email_verified_at = null;
        }
        $user->email    = $request->input('email');
        $request->session()->flash('message', translateMessage("messages.userUpdated"));

        $file = $request->file('image');
        if ($file) {
            $imageName      = "avatar" . "-" . time() . '.' . $file->extension();
            $request->image->move(public_path('assets/img/avatars'), $imageName);
            $user->avatar   = $imageName;
        }

        $old_pass = $request->input('old_password');
        $new_pass = $request->input('new_password');
        if ($old_pass && $new_pass) {
            if (Hash::check($old_pass, $user->password)) {
                $user->password   = Hash::make($new_pass);
            } else {
                $request->session()->flash('message', translateMessage("messages.passwordNotMatch"));
            }
        }

        $user->save();
        return redirect()->route('user.profile');
    }

    public function updateBankDetails(Request $request)
    {
        $user = auth()->user();
        $bankDetail = BankAccount::where(['user_id' => $user->id, 'user_type' => 'App\User'])->first();
        if (!$bankDetail) {
            $bankDetail = new BankAccount();
        }

        $bankDetail->user_id        = $user->id;
        $bankDetail->user_type      = "App\User";
        $bankDetail->bank_name      = $request->bank_name;
        $bankDetail->account_title  = $request->account_title;
        $bankDetail->account_no     = $request->account_no;
        $bankDetail->iban_no        = $request->iban_no;
        $bankDetail->sort_code      = $request->sort_code;
        $bankDetail->save();

        $request->session()->flash('message',translateMessage("messages.BankDetailSaved"));
        return redirect()->route('user.profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles  = RolesService::get();
        $user = User::find($id);
        return view('dashboard.admin.userEditForm', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'          => 'required|min:1|max:256',
            'email'         => 'required|email|max:256',
            'phone_no'      => 'required',
        ]);

        $user               = User::find($id);
        $user->name         = $request->input('name');
        $user->email        = $request->input('email');
        $user->phone_no     = $request->input('phone_no');
        $user->menuroles    = implode(",", $request->input('role'));
        $user->save();
        $request->session()->flash('message',translateMessage("messages.userUpdated"));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $transactions = Transaction::where('from_acc_id', $user->account_no)->orWhere('to_acc_id', $user->account_no)->get();
            if (count($transactions) > 0) {
                $message = translateMessage("messages.userCannotDelete");
            } else {
                $user->delete();
                $message =translateMessage("messages.userDelete") ;
            }
        }
        $request->session()->flash('message', $message);
        return redirect()->route('users.index');
    }
    public function setLocale(Request $request,$locale){

        Session::put('current_locale',$locale);
        App::setLocale($locale);

     // dd(Session::get('current_locale'));
        return redirect()->back();
    }
}
