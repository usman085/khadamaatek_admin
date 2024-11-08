<?php

namespace App\Console\Commands;

use App\Order;
use LogHelper;
use Illuminate\Console\Command;

class ExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification to customer when its service order is expred.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get all pending orders
        $orders = Order::where('status_id', 1)->orWhere('status_id', 2)->get();
        $todayDate = date('Y-m-d');
        if (count($orders) > 0) {
            foreach ($orders as $key => $value) {
                // check expiry date with today date
                $customer = $value->customer;
                if ($customer && $customer->device_token && $todayDate == $value->expiry_date) {
                    LogHelper::send_notification_FCM($customer, translateNotification(__('notification.title.order_transfered')), translateNotification(__('notification.order_expiry',['order_no' => changeToArabicDigits($value->order_no)])), $customer->id, 'expire', 'customer');
                }
            }
        }

        $this->info('Order Expiry notification sent to all customers.');
    }
}
