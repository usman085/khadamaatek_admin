<?php

namespace App\Http\Controllers;

use App\DataTables\GroupsDataTable;
use App\Group;
use LogHelper;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GroupsDataTable $dataTable)
    {
        // $groups = Group::paginate(20);
        // return view('dashboard.group.index', ['groups' => $groups]);
        return $dataTable->render('dashboard.group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.group.create');
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
            'name'    => 'required|min:3',
            'logo'    => 'image',
        ]);

        $group = new Group();
        $group->name = $request->input('name');
        $group->save();

        if ($request->hasFile('logo')) {
            
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Group", $group->id, $file_name);
        }

        $request->session()->flash('message',translateMessage('messages.group_created'));
        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('dashboard.group.edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $validatedData = $request->validate([
            'name'    => 'required|min:3',
            'logo'    => 'image',
        ]);

        $group->name = $request->input('name');
        $group->save();

        if ($request->hasFile('logo')) {
            $file_name = "logo-" . time() . "." . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('images_logos'), $file_name);
            LogHelper::uploadLogo("App\Group", $group->id, $file_name);
        }

        $request->session()->flash('message',translateMessage('messages.group_updated'));
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group, Request $request)
    {
        if ($group) {
            if ($group->departments->count() === 0) {
                $group->delete();
                $message = translateMessage('messages.groupDelete');
            } else {
                $message = translateMessage('messages.groupCannotDelete');
            }
        } else {
            $message = translateMessage('messages.groupNotFound');
        }
        $request->session()->flash('message', $message);
        return redirect()->route('groups.index');
    }
}
