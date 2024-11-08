<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Secret;
use App\User;
use LogHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Validation\ValidationException;
use Auth;
use Redirect;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        $this->middleware('guest', ['except' => ['logout', 'userLogout', 'getToken', 'checkUserExist', 'userRegistration', 'updateCustomer', 'customerLogin', 'customerRegister', 'customerVerify']]);
    }

    public function doLogin(Request $request)
{
// validate the info, create rules for the inputs
$rules = array(
    'email'    => 'required|email', // make sure the email is an actual email
    'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
);

// run the validation rules on the inputs from the form
// $validator = Validator::make(Input::all(), $rules);

// if the validator fails, redirect back to the form
// if ($validator->fails()) {
//     return Redirect::to('login')
//         ->withErrors($validator) // send back all errors to the login form
//         ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
// } else {

    // create our user data for the authentication
    $userdata = array(
        'email'     => $request->email,
        'password'  => $request->password,
    );

    // attempt to do the login
    if (Auth::attempt($userdata)) {

        // validation successful!
        // redirect them to the secure section or whatever
        // return Redirect::to('secure');
        // for now we'll just echo success (even though echoing in a controller is bad)
        return Redirect::to('admin/dashboard');
     
    } else {        

        // validation not successful, send back to form 
        return Redirect::to('login');

    }

// }
}
    public function getToken(Request $request)
    {
        $data = $request->validate([
            'phone_no' => 'required|string',
            'device_name' => 'required',
        ]);

        $customer  = Customer::where('phone_no', $data['phone_no'])->first();

        if (!$customer) {
            return response()->json([
                'message' => "User Not Found!!!",
                'result' => FALSE,
            ]);
        } else {
            $token = $customer->createToken($request->device_name)->plainTextToken;
            return response()->json([
                'result' => TRUE,
                'token' => $token,
                'user' => $customer,
            ]);
        }

        return response()->json([
            'message' => "User Not Found!!!",
            'result' => FALSE,
        ]);
    }

    public function userLogout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required',
            'user_type' => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => "Required parameters missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {

            if ($request->user_type === 'admin') {
                $user  = User::find($request->user_id);
            } else {
                $user  = Customer::find($request->user_id);
            }

            if (!$user) {
                $response = [
                    'message' => "User Not Found!!!",
                    'result' => FALSE,
                ];
            } else {
                $user->device_token = NULL;
                $user->device_type = NULL;
                $user->save();

                $response = [
                    'result' => TRUE,
                    'message' => "User logged out!",
                ];
            }
        }

        return response()->json($response, $responseCode);
    }

    public function checkUserExist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no'  => 'required|string',
            'user_type' => 'required',
            'device_token' => 'required'
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => "Required parameters missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } 
        else {
            $phone_num              = $request->phone_no;
            $phone_num_without_plus = str_replace('+', '', $request->phone_no);

            if ($request->user_type === 'admin') {
                $user  = User::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
            } else {
                $user  = Customer::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
                if (!empty($user)) {
                    $user->last_login = date('Y-m-d H:m:s');
                }
            }

            if (empty($user)) {
                $response = [
                    'message' => "User Not Found!!!",
                    'result' => FALSE,
                ];
            } else {
                $user->device_token = $request->device_token;
                $user->device_type = $request->device_type;
                $user->save();

                $token = $user->createToken(time())->plainTextToken;

                $response = [
                    'result' => TRUE,
                    'message' => "User already registered with this phone number!",
                    'user' => $user,
                    'token' => $token
                ];
            }
        }


        return response()->json($response, $responseCode);
    }

    public function userRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_no'  => 'required|string',
            'user_type' => 'required',
        ]);
        $responseCode = 200;

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => "Required parameters missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $phone_num              = $request->phone_no;
            $phone_num_without_plus = str_replace('+', '', $request->phone_no);

            if ($request->user_type === 'admin') {
                $user  = User::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
            } else {
                $user  = Customer::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();
            }

            if (!$user) {
                if ($request->user_type === 'admin') {
                    $user = new User();
                } else {
                    $user = new Customer();
                    $user->verified = "true";
                    $user->last_login = date('Y-m-d H:m:s');
                }
                $user->phone_no = $request->phone_no;
                $user->otp = mt_rand(1111, 9999);
                $user->save();
                //$user->account_no   = $user->generateAccountNumber();
                //$user->save();

                if (!empty($user)) {
                    // $user->account_no = "ACC-".$user->id;
                    $user->account_no = $user->id;
                    $user->update();
                    $phone = ($user->phone_no) ? "(" . $user->phone_no . ")" : "";
                    $admins = User::all();
                    foreach ($admins as $admin) {
                        LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.new_user')), translateNotification(__('notification.new_user',['phone_no' => changeToArabicDigits($phone)])), $user->id, 'new_user');
                    }
                }

                $token = $user->createToken(time())->plainTextToken;

                LogHelper::store($user->id, "User Registered.");

                $response = [
                    'message' => "User registered successfully!",
                    'result' => TRUE,
                    'user' => $user,
                    'token' => $token
                ];
            } else {
                $token = $user->createToken(time())->plainTextToken;
                $response = [
                    'result' => FALSE,
                    'message' => "User already registered with this phone number!",
                    'user' => $user,
                    'token' => $token
                ];
                $responseCode = 500;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function customerLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_code'    => 'required|numeric',
            'phone_no'      => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => FALSE,
                'message' => "Phone Number missing",
                'errors'    => $validator->errors(),
            ], 400);
        } else {
            $phone_num = $request->phone_code . $request->phone_no;
            $customer  = Customer::where('phone_no', $phone_num)->orWhere('phone_no', ('+' . $phone_num))->first();

            if ($customer) {
                if (!$customer->verified || $customer->verified === false) {
                    $response = [
                        'result'    => FALSE,
                        'message'   => "Profile Not Verified",
                    ];
                    $responseCode = 500;
                } else {
                    $token = $customer->createToken(time())->plainTextToken;
                    // $otp = mt_rand(1111, 9999);
                    $customer->last_login = date('Y-m-d H:m:s');
                    $customer->save();


                    $secret = new Secret();
                    $secret->user_id = $customer->id;
                    $secret->secret = $token;
                    $secret->save();

                    LogHelper::store($customer->id, "User Logged in.");
                    $response = [
                        'user' => $customer,
                        'token' => $token
                    ];

                    return response($response, 201);
                }
            } else {
                return response()->json([
                    'result' => FALSE,
                    'message' => "User Not Found",
                    "errors"  => [
                        "phone_no" => [
                            "User Not Found"
                        ]
                    ],
                ], 404);
            }
        }
    }

    public function customerRegister(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'phone_code'    => 'required|numeric',
            'phone_no'      => 'required|numeric|unique:customers,phone_no',
        ]);
      
        $responseCode = 200;

        if ($validator->fails()) {
            
            $response = [
                'result'    => FALSE,
                'message'   => "Failed to Register. Required Data is missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } 
        else {
            
            $phone_num = $request->phone_code . $request->phone_no;
            $phone_num_without_plus = str_replace('+', '', $phone_num);

             $customer  = Customer::where('phone_no', $phone_num_without_plus)->orWhere('phone_no', $phone_num)->first();

            if ($customer && $customer->verified === 'true') {
                $response = [
                    'result'    => FALSE,
                    'message'   => "Phone Number already registered.",
                ];
                $responseCode = 500;
            } else {
                if (!$customer) {
                    $customer = new Customer();
                    $customer->phone_no = $phone_num;
                }

                $otp = mt_rand(1111, 9999);
                $customer->otp      = $otp;

                // $otpReponse = $this->sendOTPSMS($customer);

                // if ($otpReponse[0] >= 1 || $otpReponse[0] >= 11 || $otpReponse[0] == -4 || $otpReponse[0] == -6) {
                //     $response = [
                //         'result' => FALSE,
                //         'message' => $otpReponse[1],
                //     ];
                //     $responseCode = 500;
                // } else {
                    $customer->save();
                    $customer->account_no =  $customer->generateAccountNumber();
                    $customer->save();

                    // LogHelper::store($customer->id, "User Registered.");

                    if ($customer) {
                        if ($customer) {
                            $phone = ($customer->phone_no) ? "(" . $customer->phone_no . ")" : "";
                            $admins = User::all();
                            foreach ($admins as $admin) {
                                LogHelper::send_notification_FCM($admin, translateNotification(__('notification.title.new_user')), translateNotification(__('notification.new_user',['phone_no' => changeToArabicDigits($phone)])), $customer->id, 'new_user');
                            }
                        }
                    // }
                    $response = [
                        'result' => TRUE,
                        'user' => $customer,
                    ];
                }
            }
        }
        return response()->json($response, $responseCode);
    }

    public function sendOTPSMS($user)
    {
        $username   = "923044554566";     ///Your Username
        $password   = "=[-p0o9i";         ///Your Password
        $mobile     = $user->phone_no;      ///Recepient Mobile Number
        $sender     = "SoftechVisions";
        $message    = "SMS Alert\nDear User you registered at Khadamateek.\nYour verification code is {$user->otp}.\n\n" . URL::to('/');

        ////sending sms
        $post       = "sender=" . urlencode($sender) . "&mobile=" . urlencode($mobile) . "&message=" . urlencode($message) . "";
        $url        = "https://sendpk.com/api/sms.php?username={$username}&password={$password}";
        $timeout    = 0; // set to zero for no timeout
        $ch         = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($ch);
        /*Print Responce*/
        return explode(":", $result);
    }

    public function customerVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verify_code'   => 'required|min:4|max:4',
            'userData'      => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => "Failed to verify. Data missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $customer = Customer::find($request->userData['id']);
            if ($customer) {
                if ($request->verify_code === $customer->otp) {
                    $customer->first_name = "Temp";
                    $customer->last_name = "User";
                    $customer->verified = "true";
                    $customer->save();

                    LogHelper::store($customer->id, "User verified.");
                    $response = [
                        'user' => $customer,
                    ];

                    return response($response, 201);
                } else {
                    $response = [
                        'result'    => FALSE,
                        'message'   => "Sorry! OTP Does not match!!!",
                    ];
                    $responseCode = 400;
                }
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   => "Customer not found!!",
                ];
                $responseCode = 500;
            }
        }

        return response()->json($response, $responseCode);
    }

    public function updateCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'    => 'required|min:3',
            'last_name'     => 'required|min:3',
        ]);

        if ($validator->fails()) {
            $response = [
                'result'    => FALSE,
                'message'   => "Failed to verify. Data missing!",
                'errors'    => $validator->errors(),
            ];
            $responseCode = 400;
        } else {
            $customer = Customer::find($request->user['id']);
            if ($customer && $customer->verified == 'true') {
                $token = $customer->createToken(time())->plainTextToken;

                if ($customer->first_name !== $request->first_name) {
                    LogHelper::store($customer->id, "User updated First Name.");
                }
                if ($customer->last_name !== $request->last_name) {
                    LogHelper::store($customer->id, "User updated Last Name.");
                }

                $customer->first_name   = $request->input('first_name');
                $customer->last_name    = $request->input('last_name');

                if ($customer->email !== $request->email) {
                    $customer->email_verified_at = NULL;
                }

                if ($request->email != $customer->email) {
                    LogHelper::store($customer->id, "User updated Email.");
                    $customer->email = $request->input('email');
                    $user->email_verified_at  = null;
                }

                if ($request->cnic != $customer->cnic) {
                    LogHelper::store($customer->id, "User updated CNIC.");
                    $customer->cnic = $request->input('cnic');
                }

                if ($request->gender != $customer->gender) {
                    LogHelper::store($customer->id, "User updated Gender.");
                    $customer->gender = $request->input('gender');
                }

                if ($request->nationality != $customer->nationality) {
                    LogHelper::store($customer->id, "User updated Nationality.");
                    $customer->nationality = $request->input('nationality');
                }

                if ($request->address != $customer->address) {
                    LogHelper::store($customer->id, "User updated Address.");
                    $customer->address = $request->input('address');
                }

                $customer->save();

                $response = [
                    'user' => $customer,
                    'token' => $token
                ];

                return response($response, 201);
            } else {
                $response = [
                    'result'    => FALSE,
                    'message'   => "Customer not found!!",
                ];
                $responseCode = 404;
            }
        }
        return response()->json($response, $responseCode);
    }

    public function throwErrorMessage($message)
    {
        throw ValidationException::withMessages([
            'message' => $message,
        ]);
    }
}
