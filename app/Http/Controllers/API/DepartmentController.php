<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Department;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DepartmentController extends Controller
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

    public function getGroups()
    {
        $groups = Group::with('logo')->get();
        if ($groups) {
            $response = [
                'result'        => TRUE,
                'groups'   => $groups,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.group_not_found'),
            ];
            $responseCode = 404;
        }

        return response()->json($response, $responseCode);
    }

    public function getDepartments()
    {
        $departments = Department::all();
        if ($departments) {
            $response = [
                'result'        => TRUE,
                'departments'   => $departments,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.department_not_found'),
            ];
            $responseCode = 404;
        }

        return response()->json($response, $responseCode);
    }

    public function getDepartmentsByGroup(Request $request,$group_id)
    {
        $departments = Department::with('logo')->where('group_id', $group_id)->get();
        if ($departments) {
            $response = [
                'result'        => TRUE,
                'departments'   => $departments,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.department_not_found'),
            ];
            $responseCode = 404;
        }

        return response()->json($response, $responseCode);
    }

    public function getCategoriesbyDepartment(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
        ]);

        $categories = Category::with('logo')->where('department_id', $request->department_id)->whereNull('parent_id')->get();

        if ($categories) {
            $response = [
                'result'        => TRUE,
                'categories'   => $categories,
            ];
            $responseCode = 200;
        } else {
            $response = [
                'result'    => FALSE,
                "message"   =>translateMessage('messages.category_not_found'),
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
