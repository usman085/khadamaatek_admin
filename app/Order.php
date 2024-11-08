<?php

namespace App;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'agreed_fee', 'order_status', 'order_date'];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category')->withTrashed();
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function transactions()
    {
        return $this->hasOne('App\Transaction');
    }

    public function template()
    {
        return $this->hasOne('App\Requirement');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function getUnreadMessageCount($type)
    {
        return $this->messages->where('user_type', $type)->whereNull('read_at')->count();
    }

    public function changeMessageAsRead($type)
    {
        $date = date('Y-m-d H:i:s');
        DB::update("UPDATE messages set read_at = '{$date}' where order_id = :order_id AND user_type = :type", [$this->id, $type]);
    }

    public function generateOrderNumber()
    {
        // $date = date('Y-m-d H:i:s');
        // $total_days   = $d->format('t');

        // Get order number from total order number in current month
        $dt = Carbon::now();
        $total_orders = DB::table('orders')->whereYear('created_at', $dt->year)
            ->whereMonth('created_at', $dt->month)->count();
        return date('ym') . str_pad(($total_orders + 1), 5, "0", STR_PAD_LEFT);
    }
}
