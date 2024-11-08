<?php

namespace App\Http\Controllers;

use App\Category;
use App\DataTables\DepartmentsDataTable;
use App\Department;
use App\Group;
use LogHelper;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        // dd(Session::get('current_locale'));
    }

    public $response_message = "";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DepartmentsDataTable $dataTable)
    {
        // $departments = Department::paginate(20);
        // return view('dashboard.departments.index', ['departments' => $departments]);
        return $dataTable->render('dashboard.departments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::orderBy('name')->get();
        $departments = Department::all();
        return view('dashboard.departments.create', ['departments' => $departments, 'groups' => $groups]);
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
            'name'        => 'required|min:3',
            'group_id'    => 'required',
            'logo'        => 'image'
        ]);

        $department = new Department();
        $department->name = $request->input('name');
        $department->group_id = $request->input('group_id');
        $department->save();

        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $department->id);
        }

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Department", $department->id, $file_name);
        }

        $request->session()->flash('message',translateMessage('messages.department_created'));
        return redirect()->route('department.index');
    }

    public function saveWebsite($rows, $dep_id)
    {
        $obj = [];
        foreach ($rows as $row) {
            $i = 0;
            $website = new Website();
            $website->website_name = $row[$i]['website_name'];
            $website->website_url = $row[$i + 1]['website_url'];
            $website->model_id = $dep_id;
            $website->model_type = "App\Department";

            $website->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function getCategories(Department $department)
    {
        $categories = Category::where('department_id', $department->id)->whereNull('parent_id')->get();
        // if ($categories) {
        //     foreach ($categories as $key => $value) {
        //         $value->subcategories;
        //     }
        // }
        return response()->json($categories);
    }

    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $groups = Group::all();
        return view('dashboard.departments.edit', ['department' => $department, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validatedData = $request->validate([
            'name'        => 'required|min:3',
            'group_id'    => 'required',
            'logo'        => 'image'
        ]);


        $department->name = $request->input('name');
        $department->group_id = $request->input('group_id');
        $department->save();
        // Delete old Rows
        $old_webs = Website::where(['model_id' => $department->id, 'model_type' => 'App\Department']);
        $old_webs->forceDelete();
        // insert new rows
        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $department->id);
        }

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Department", $department->id, $file_name);
        }
        $request->session()->flash('message',translateMessage('messages.department_updated'));
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Request $request)
    {
        if ($department) {
            if ($department->services->count() === 0) {
                $old_webs = Website::where(['model_id' => $department->id, 'model_type' => 'App\Department']);
                $old_webs->delete();
                $department->delete();
                $this->response_message =translateMessage('messages.department_deleted');
            } else {
                $this->response_message =translateMessage('messages.unable_to_delete_department');
            }
        } else {
            $this->response_message =translateMessage('messages.department_not_found');
        }
        $request->session()->flash('message', $this->response_message);
        return redirect()->route('department.index');
    }
}
