<?php

namespace App\Http\Controllers;

use App\Document;
use App\FormBuilder;
use App\RequirementTemplate;
use App\RequirementTemplateDetail;
use Illuminate\Http\Request;

class FormBuilderController extends Controller
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
    public function index()
    {
        $templates = RequirementTemplate::with('requirement_detail')->paginate();
        return view('dashboard.formbuilders.index', ['forms' => $templates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documents = Document::all();
        return view('dashboard.formbuilders.create', ['documents' => $documents]);
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
            'title'    => 'required|min:3|max:64|unique:requirement_templates,name',
        ]);

        $form               = new RequirementTemplate();
        $form->name         = $request->input('title');
        $form->user_id      = auth()->user()->id;
        $form->save();

        $chunked_arr = array_chunk($request->input('rows'), 2, false);
        $formatedArr = $this->getJsonFormat($chunked_arr);
        foreach ($formatedArr as $row) {
            $formDetaail = new RequirementTemplateDetail();
            $formDetaail->label                     = $row['label'];
            $formDetaail->document_id               = $row['document'];
            $formDetaail->requirement_template_id   = $form->id;
            $formDetaail->save();
        }
        $request->session()->flash('message',translateMessage('messages.req_temp_created'));
        return redirect()->route('forms.index');
    }

    public function getJsonFormat($rows)
    {
        $arr = [];
        foreach ($rows as $row) {
            $ind = 0;
            $ass_arr = [
                'label'         => $row[$ind]['label'],
                'document'      => $row[$ind + 1]['document'],
            ];
            $arr[] = $ass_arr;
            $ind++;
        }
        return $arr;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function show(RequirementTemplate $template)
    {
        return view('dashboard.formbuilders.show', ['form' => $template]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function edit(RequirementTemplate $template)
    {
        $documents = Document::all();
        return view('dashboard.formbuilders.edit', ['form' => $template, 'documents' => $documents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequirementTemplate $template)
    {
        $validatedData = $request->validate([
            'title'    => 'required|min:3|max:64',
        ]);
        $associated = [];
        $services = $template->services()->get();
        if (count($services) > 0) {
            foreach ($services as $key => $value) {
                $orders = $value->orders;
                if (count($orders) > 0) {
                    $associated[] = count($orders);
                }
            }
        }

        if (count($associated) > 0) {
            $request->session()->flash('error', true);
            $request->session()->flash('message',translateMessage('messages.unable_to_update_req_temp'));
        } else {
            $template->name         = $request->input('title');
            $template->user_id      = auth()->user()->id;
            $template->save();

            // delete old detail rows
            foreach ($template->requirement_detail as $row) {
                $row->delete();
            }

            $chunked_arr = array_chunk($request->input('rows'), 2, false);
            $formatedArr = $this->getJsonFormat($chunked_arr);

            foreach ($formatedArr as $row) {
                $formDetaail = new RequirementTemplateDetail();
                $formDetaail->label                     = $row['label'];
                $formDetaail->document_id               = $row['document'];
                $formDetaail->requirement_template_id   = $template->id;
                $formDetaail->save();
            }

            $request->session()->flash('message',translateMessage('messages.req_temp_updated'));
        }

        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormBuilder  $formBuilder
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequirementTemplate $template, Request $request)
    {
        if ($template) {
            if ($template->services->count() === 0) {
                $template->delete();
                // delete old detail rows
                foreach ($template->requirement_detail as $row) {
                    $row->delete();
                }
                $message = translateMessage('messages.req_temp_delete');
            } else {
                $message = translateMessage('messages.req_temp_notDelete');
            }
        } else {
            $message = translateMessage('messages.req_temp_notFound');
        }

        $request->session()->flash("message", $message);
        return redirect()->route('forms.index');
    }
}
