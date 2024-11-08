<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Document;
use App\CustomerDocument;
use App\Http\Controllers\Controller;
use App\Order;
use App\Service;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getSubCategoriesWithServices(Request $request)
    {
        if (!$request->category_id) {
            $response = [
                'result'        => FALSE,
                'message'       =>translateMessage('messages.category_id_required'),
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'        => TRUE
            ];
            $category = Category::where('id',$request->category_id)->with('subcategories','services.logo')->first();
            if ($category) {
                if (count($category->subcategories) > 0) {
                    $subcats = Category::with('logo')->where('parent_id', $category->id)->with('services.logo')->get();
                    $response['categories'] = $subcats;
                    $responseCode = 200;
                }
                if (count($category->services) > 0) {
                    $response['services']   =   $category->services;
                    $response['message']    =  translateMessage('messages.category_not_found');
                    $responseCode = 200;
                }
                if (!(isset($response['categories']) || isset($response['services']))) {
                    $response['result']     =   FALSE;
                    $response['message']    =  translateMessage('messages.category_not_found');
                    $responseCode = 200;
                }
            } else {
                $response = [
                    'result'    => FALSE,
                    "message"   =>translateMessage('messages.category_not_found'),
                ];
                $responseCode = 404;
            }
        }


        return response()->json($response, $responseCode);
    }

    public function getSubCategories(Request $request)
    {

        if (!$request->category_ids) {
            $response = [
                'result'        => FALSE,
                'message'       =>translateMessage('messages.category_id_required'),
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'        => TRUE
            ];
            $ids = json_decode($request->category_ids);
            $categories = Category::whereIn('id', $ids)->get();
            if ($categories) {
                $response['categories'] = $categories;
                $responseCode = 200;
            } else {
                $response = [
                    'result'    => FALSE,
                    "message"   =>translateMessage('messages.category_not_found'),
                ];
                $responseCode = 404;
            }
        }


        return response()->json($response, $responseCode);
    }

    public function getServices(Request $request)
    {
        if (!$request->category_id) {
            $response = [
                'result'        => FALSE,
                'message'       =>translateMessage('messages.category_id_required'),
            ];
            $responseCode = 200;
        } else {
            $category = Category::find($request->category_id);

            if ($category) {
                if (count($category->services) > 0) {
                    $services = Service::with('logo')->where('category_id', $category->id)->get();
                    $response = [
                        'result'    => TRUE,
                        'services'  => $services,
                        "message"   =>translateMessage('messages.service_found'),
                    ];
                    $responseCode = 200;
                } else {
                    $response = [
                        'result'    => FALSE,
                        "message"   =>translateMessage('messages.service_not_found'),
                    ];
                    $responseCode = 404;
                }
            } else {
                $response = [
                    'result'    => FALSE,
                    "message"   =>translateMessage('messages.category_not_found'),
                ];
                $responseCode = 404;
            }
        }


        return response()->json($response, $responseCode);
    }


    public function getServiceDetail($service_id, $user_id)
    {
        $service = Service::where('id', $service_id)->first();
        $documents = Document::whereIn('id',getDocumentListArray($service->formbuilder_id))->get();
        $customer_documents = [];
        if ($service) {
            foreach ($documents as $key => $doc) {
                $customer_documents[$key]['label']  = $doc->name;
                $customer_documents[$key]['document_type']  = $doc->document_type;
                $customer_documents[$key]['document_id']    = $doc->id;
                $customer_documents[$key]['data']           = CustomerDocument::where(['document_id' => $doc->id, 'user_id' => $user_id])->get();
            }
            // $order = Order::where('service_id', $service_id)->orderBy('id', 'desc')->limit(1)->first();
            // if ($service->template) {
            //     // $service->template->schema =  json_decode($service->template->schema);
            // }
            $response = [
                'result'                => TRUE,
                'service'               => $service,
                'required_documents'    => $customer_documents,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.service_not_found'),
            ];
            $responseCode = 404;
        }
        return response()->json($response, $responseCode);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
