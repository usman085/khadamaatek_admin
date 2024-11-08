<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Category;
use App\Department;
use App\Website;
use App\Group;
use LogHelper;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CategoriesDataTable $dataTable)
    {
        $categories = Category::whereNull('parent_id')->with('department')->with('department.group')->get();
        return view('dashboard.categories.index', ['categories' => $categories]);
        // return $dataTable->render('dashboard.categories.index');
    }

    public function create()
    {
        //$categories = Category::orderBy('name')->get();
        $groups = Group::with('departments')->orderBy('name')->get();
        //$depts = Department::orderBy('name')->get();
        return view('dashboard.categories.create', ['groups' => $groups]);
    }

    public function view_child($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', ['category' => $category]);
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
            'name'             => 'required|min:1',
            'department_id'    => 'required|min:1|numeric',
            'logo'             => 'image',
        ]);

        $parentId = $request->input('parent_id');
        $subCatIds = $request->category_id;

        if(is_array($subCatIds) && !empty($subCatIds)){
            $lastNodeId = last($subCatIds);
            if($lastNodeId == null){
                if(count($subCatIds) > 1){
                    $parentId = $subCatIds[(count($subCatIds) - 2)];
                }
            }else{
                $parentId = $lastNodeId;
            }
        }

        $category = new Category();
        $category->name             = $request->input('name');
        $category->parent_id        = $parentId;
        $category->department_id    = $request->input('department_id');
        $category->save();

        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $category->id);
        }

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Category", $category->id, $file_name);
        }

        $request->session()->flash('message',translateMessage('messages.service_created'));
        return redirect()->route('category.index');
    }

    public function saveWebsite($rows, $cat_id)
    {
        $obj = [];
        foreach ($rows as $row) {
            $i = 0;
            $website = new Website();
            $website->website_name = $row[$i]['website_name'];
            $website->website_url = $row[$i + 1]['website_url'];
            $website->model_id = $cat_id;
            $website->model_type = "App\Category";

            $website->save();
        }
    }

    public function getSubCategories($id)
    {
        $sub_cats = Category::Where('parent_id', $id)->get();
        return response()->json($sub_cats);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editCat = Category::findorfail($id);
        $catTree = Category::categoryTree($editCat);
        $depts = Department::all();
        $groups = Group::with('departments')->orderBy('name')->get();
        $group_id = 0;
        foreach ($depts as $key => $dept) {
            if ($dept->id == $editCat->department_id) {
                $group_id = $dept->group_id;
                break;
            }
        }
        $categories = Category::where('department_id', $editCat->department_id)->whereNull('parent_id')->get();
        return view('dashboard.categories.edit', ['category' => $editCat, 'catTree' => $catTree, 'categories' => $categories, 'departments' => $depts, 'groups' => $groups, 'group_id' => $group_id]);
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
        $validatedData = $request->validate([
            'name'             => 'required|min:1',
            'department_id'    => 'required|min:1|numeric',
            'logo'             => 'image',
        ]);

        $parentId = $request->input('parent_id');
        $subCatIds = $request->category_id;
        if(is_array($subCatIds) && !empty($subCatIds)){
            $lastNodeId = last($subCatIds);
            if($lastNodeId == null){
                if(count($subCatIds) > 1){
                    $parentId = $subCatIds[(count($subCatIds) - 2)];
                }
            }else{
                $parentId = $lastNodeId;
            }
        }

        $category                   = Category::find($id);
        $category->name             = $request->input('name');
        $category->parent_id        = $parentId;
        $category->department_id    = $request->input('department_id');
        $category->save();

        // Delete old Rows
        $old_webs = Website::where(['model_id' => $category->id, 'model_type' => 'App\Category']);
        $old_webs->forceDelete();
        // insert new rows
        if ($request->input('rows')) {
            $website_rows = array_chunk($request->input('rows'), 2);
            $this->saveWebsite($website_rows, $category->id);
        }

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Category", $category->id, $file_name);
        }

        $request->session()->flash('message',translateMessage('messages.service_updated'));
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $category = Category::find($id);
        if ($category) {
            if ($category->subcategories->count() == 0 && $category->services->count() === 0) {
                $old_webs = Website::where(['model_id' => $category->id, 'model_type' => 'App\Category']);
                $old_webs->delete();
                $category->delete();
                $message = translateMessage('messages.catDelete');
            } else {
                $message =  translateMessage('messages.catNotDelete');
            }
        } else {
            $message =  translateMessage('messages.caNotFound');
        }
        $request->session()->flash('message', $message);
        return redirect()->back();
    }
}
