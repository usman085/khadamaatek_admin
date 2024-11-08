<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "from_type",
        "from_acc_id",
        "from_bank_name",
        "from_bank_accno",
        "to_type",
        "to_bank_name",
        "to_bank_accno",
        "to_acc_id",
        "amount",
        "order_id",
        "attachment",
        "status",
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function from_customer()
    {
        return $this->belongsTo('App\Customer', 'from_acc_id', 'account_no');
    }

    public function to_customer()
    {
        return $this->belongsTo('App\Customer', 'to_acc_id', 'account_no');
    }

    public function from_user()
    {
        return $this->belongsTo('App\User', 'from_acc_id', 'account_no');
    }

    public function to_user()
    {
        return $this->belongsTo('App\User', 'to_acc_id', 'account_no');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function getCreatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }
    
    public function getUpdatedAtAttribute($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public function remaining_balance($transaction_id, $user_id, $user_type = "App\Customer")
    {
        $balance = Wallet::where(['user_id' => $user_id, 'user_type' => $user_type])->where('transaction_id', '<=', $transaction_id)->sum('amount');
        return $balance;
    }
}
