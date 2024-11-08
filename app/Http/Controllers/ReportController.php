<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Order;
use App\Service;

use App\Models\Status;
use App\DataTables\OrdersDataTable;
class ReportController extends Controller
{
      public function __construct()
    {
        $this->middleware(['auth', 'auth:sanctum']);
    }

    public function sumVal($val){
        return $val +=$val;
    }
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrdersDataTable $dataTable)
    {
       $status = Status::where('name','completed')->first();
    //    completed
    // ->selectRaw('count(customer_id) as customers ,service_id,sum(agreed_fee) as total_fee,customer')
    // ->groupBy('service_id','customer_id')
          $orders = Order::where('status_id',$status->id)->selectRaw('count(customer_id) as customers ,service_id,sum(agreed_fee) as total_fee')->groupBy('service_id')->get();
        
        //  dd($orders);
  return $getOrders = $orders->map(function ($product) use($status) {
  return [
      'service_id' =>Service::where('id',$product->service_id)->select(':id,name')->first()
  ];
  });
          

          //  $getOrders = $orders->map()
    //    return   $getOrders = $orders->map(function ($product) use($status) {
    //             return [
    //                 'customer'       =>$product->customer != null ?$product->customer->id:null,
    //                 'customer_num'       =>$product->customer != null ?$product->customer->count():null,
    //                 'service'        => $product->service->name,
    //                 'service_id'        => $product->service->id,

    //                 'agreed_fee'     => $this->sumVal($product->agreed_fee)
    //             ];
    //         });
            // dd( $getOrders)
            $result = [];
            foreach ($getOrders as $or) {
                  $hasCustomer = $result->contains(function ($site, $key) {
                return $site->url == 'https://google.com';
            });
                if ( $hasCustomer){

                }else{

                }
            }
           
         return view('dashboard.reports.salesReport', ['orders' => $orders]);
        // return $dataTable->render('dashboard.reports.salesReport');
    }

}
