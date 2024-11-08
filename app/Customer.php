<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    // use SoftDeletes;
    use Notifiable;
    use HasApiTokens;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'cnic',
        'nationality',
        'gender',
        'phone_no',
        'address',
        'verified',
        'email_verified_at',
    ];

    protected $hidden = [
        'otp'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function getAuthIdentifier()
    {
        return "id";
    }

    public function verifyCustomer()
    {
        return $this->hasOne('App\VerifyCustomer', 'user_id');
    }

    public function messages()
    {
        return $this->morphMany('App\Message', 'relatedModels');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function generateAccountNumber()
    {
        // return 'ACC-' . str_pad($this->id, 5, "0", STR_PAD_LEFT);
        return str_pad($this->id, 5, "0", STR_PAD_LEFT);
    }

    public function requests()
    {
        return $this->morphMany('App\NumberChangeRequest', 'user');
    }

    public function logs()
    {
        return $this->morphMany('App\Log', 'user');
    }

    public function notifications()
    {
        return $this->morphMany('App\UserNotification', 'user');
    }

    public function wallet()
    {
        return $this->hasMany('App\Wallet', 'user_id');
    }

    public function fromTransaction()
    {
        return Wallet::where(['user_id' => $this->id, 'user_type' => "App\Customer"])->count('amount');
    }

    public function documents()
    {
        return $this->morphMany('App\CustomerDocument', 'user');
    }
    public function transactionDetail()
    {
        return $this->hasOne('App\Transaction', 'from_acc_id');
    }
    public function transaction()
    {
        return Transaction::where(['from_acc_id' => $this->account_no, 'from_type' => "App\Customer"])->count('amount');
    }
}
