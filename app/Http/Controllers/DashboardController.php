<?php

namespace App\Http\Controllers;

use App\Order;
use App\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $total_services = Order::count();
        $pending_orders = Order::where('status_id', 1)->count();
        $inprocess_orders = Order::where('status_id', 2)->count();
        $confirmed_orders = Order::where('status_id', 3)->count();
        $completed_orders = Order::where('status_id', 4)->count();
        $cancelled_orders = Order::where('status_id', 5)->count();

        return view('dashboard.homepage', compact('total_services', 'pending_orders', 'inprocess_orders', 'confirmed_orders', 'completed_orders', 'cancelled_orders'));
    }
}
