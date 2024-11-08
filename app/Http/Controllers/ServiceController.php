<?php

namespace App\Http\Controllers;

use App\Category;
use App\DataTables\ServicesDataTable;
use App\Department;
use App\FormBuilder;
use App\Group;
use App\RequirementTemplate;
use App\Service;
use App\Website;
use App\Document;
use LogHelper;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check.role');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServicesDataTable $dataTable)
    {
        // dd($dataTable);
        $services = Service::with(['department','category'])->orderBy('id', 'DESC')->get();
      
        // return json_decode( $services,true);

        return view('dashboard.services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::with('departments')->orderBy('name')->get();
        $categories = Category::all();
        //$departments = Department::all();
        $forms = Document::all();

        return view('dashboard.services.create', compact('categories', 'groups', 'forms'));
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
            'name'              => 'required|max:64',
            'group_id'          => 'required',
            'department_id'     => 'required',
            'fee'               => 'required',
            'formbuilder_id'    => 'required',
            'logo'              => 'image',
        ]);
        $subcat_arr = array_filter($request->input('category_id'));
        $document_templates = array_filter($request->input('formbuilder_id'));
        $category_id = 0;
        if (!empty($subcat_arr))
            $category_id = $subcat_arr[count($subcat_arr) - 1];


        $service = new Service();
        $service->name              = $request->input('name');
        $service->service_detail    = $request->input('service_detail');
        $service->fee               = $request->input('fee');
        $service->group_id          = $request->input('group_id');
        $service->category_id       = $category_id;
        $service->department_id     = $request->input('department_id');
        $service->formbuilder_id    = json_encode($document_templates);
        $service->sub_category_id   = json_encode($subcat_arr);
        $service->save();

        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $service->id);
        }

        // Save Logo
        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Service", $service->id, $file_name);
        }

        $request->session()->flash('message', translateMessage("messages.serviceCreated"));
        return redirect()->route('service.index');
    }

    public function saveWebsite($rows, $service_id)
    {
        $obj = [];
        foreach ($rows as $row) {

            if (strlen($row[0]['website_name']) <= 0 ||  strlen($row[0]['website_name']) <= 0) {
                continue;
            }

            $website = new Website();
            $website->website_name = $row[0]['website_name'];
            $website->website_url = $row[1]['website_url'];
            $website->model_id = $service_id;
            $website->model_type = "App\Service";

            $website->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        // $categories = Category::all();
        $groups = Group::with('departments')->get();
        //$departments = Department::all();
        $forms = Document::all();
        // $forms = RequirementTemplate::all();
        $categories = $this->getCategoriesTree($service->category_id);

        $service->formbuilder_id = getDocumentListArray($service->formbuilder_id);
        return view('dashboard.services.edit', compact('service', 'groups', 'categories', 'forms'));
    }

    function getCategoriesTree($main_id)
    {
        $main = [];
        $cats = [];
        $subcat = Category::find($main_id);
        if (!isset($subcat))
            return [];
        $parent = $subcat->parent_category;

        // Get All Subcats ids
        while ($subcat) {
            $cats[] = $subcat->id;
            if ($subcat->parent_category) {
                $subcat = Category::find($parent->id);
                $parent = $subcat->parent_category;
            } else {
                $subcat = null;
            }
        }
        $cats = array_reverse($cats);
        // Get All Categories with ids
        for ($i = 0; $i < count($cats); $i++) {
            $categories = [];
            if ($i == 0) {
                $categories['data'] = Category::all()->whereNull('parent_id');
                $categories['selected_id'] = $cats[$i];
            } else {
                $categories['data'] = Category::find($cats[$i - 1])->subcategories;
                $categories['selected_id'] = $cats[$i];
            }
            $main[] = $categories;
        }
        if(!empty($main)){
            $lastCat = last($main);
            $lastNode = Category::where("parent_id", $lastCat['selected_id'])->get();
            if(count($lastNode) > 0){
                $main[] = ["data"=> $lastNode, "selected_id"=>0];
            }
        }
        return $main;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'name'              => 'required',
            'group_id'          => 'required',
            'department_id'     => 'required',
            'fee'               => 'required',
            'formbuilder_id'    => 'required',
        ]);

        $subcat_arr = array_filter($request->input('category_id'));
        $category_id = 0;
        if (!empty($subcat_arr))
            $category_id = $subcat_arr[count($subcat_arr) - 1];

        $service->name              = $request->input('name');
        $service->service_detail    = $request->input('service_detail');
        $service->group_id          = $request->input('group_id');
        $service->fee               = $request->input('fee');
        $service->category_id       = $category_id;
        $service->sub_category_id   = json_encode($subcat_arr);
        $service->formbuilder_id    = $request->input('formbuilder_id');
        $service->department_id     = $request->input('department_id');
        $service->save();

        // Delete old Rows
        $old_webs = Website::where(['model_id' => $service->id, 'model_type' => 'App\Service']);
        $old_webs->forceDelete();
        // insert new rows
        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $service->id);
        }

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Service", $service->id, $file_name);
        }

        $request->session()->flash('message',translateMessage("messages.serviceUpdate"));
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service, Request $request)
    {
        if ($service) {
            if ($service->orders->count() == 0) {
                $old_webs = Website::where(['model_id' => $service->id, 'model_type' => 'App\Service']);
                $old_webs->delete();
                $service->delete();
                $message = translateMessage("messages.serviceDelete");
            } else {
                $message =translateMessage("messages.serviceCannotDelete");
            }
        } else {
            $message =translateMessage("messages.serviceNotFound") ;
        }
        $request->session()->flash('message', $message);
        return redirect()->route('service.index');
    }
}
