<?php

namespace App\Http\Controllers;

use App\CustomerDocument;
use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
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
        $docs = Document::get();
        return view('dashboard.documents.index', ['forms' => $docs]);
    }
    public function getDocumentTypeList(){
        return Document::whereNotNull('document_type')->pluck('document_type');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.documents.create',[
            'documents' => $this->getDocumentTypeList()
        ]);
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
            'title'    => 'required|min:3|max:64',
        ]);

        $chunked_arr = array_chunk($request->input('rows'), 5, false);
        $formatedArr = $this->getJsonFormat($chunked_arr);

        $form = new Document();
        $form->name = $request->input('title');
        $form->document_type = $request->input('document_type');
        $form->schema = json_encode($formatedArr);
        $form->save();
        $request->session()->flash('message',translateMessage('messages.document_created'));
        return redirect()->route('documents.index');
    }

    public function getJsonFormat($rows)
    {
        $arr = [];
        foreach ($rows as $row) {
            $ind = 0;
            if ($row[$ind + 1]['type'] == 'file') {
                $ass_arr = [
                    'label'         => $row[$ind]['label'],
                    'model'         => preg_replace('/\s+/', '_', strtolower($row[$ind]['label'])),
                    // "inputName"     => preg_replace('/\s+/', 's_', strtolower($row[$ind]['label'])),
                    'type'          => 'upload',
                    'inputType'     => '',
                    'placeholder'   => $row[$ind + 2]['placeholder'],
                    'required'      => filter_var($row[$ind + 3]['required'], FILTER_VALIDATE_BOOLEAN),
                    'readonly'      => filter_var($row[$ind + 4]['readonly'], FILTER_VALIDATE_BOOLEAN),
                ];
            } else {
                $ass_arr = [
                    'label'         => $row[$ind]['label'],
                    'model'         => preg_replace('/\s+/', '_', strtolower($row[$ind]['label'])),
                    'type'          => 'input',
                    'inputType'     => $row[$ind + 1]['type'],
                    'placeholder'   => $row[$ind + 2]['placeholder'],
                    'required'      => filter_var($row[$ind + 3]['required'], FILTER_VALIDATE_BOOLEAN),
                    'readonly'      => filter_var($row[$ind + 4]['readonly'], FILTER_VALIDATE_BOOLEAN),
                ];
            }
            $arr[] = $ass_arr;
            $ind++;
        }
        return $arr;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return view('dashboard.documents.show', ['form' => $document]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('dashboard.documents.edit', ['form' => $document,'documents' => $this->getDocumentTypeList()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $validatedData = $request->validate([
            'title'    => 'required|min:3|max:64',
        ]);
        $customer_docs = CustomerDocument::where('document_id', $document->id)->get();
        if(count($customer_docs) > 0){
            $request->session()->flash('message',translateMessage('messages.unable_to_update_document'));
            $request->session()->flash('error', true);
        } else{
            $chunked_arr = array_chunk($request->input('rows'), 5, false);
            $formatedArr = $this->getJsonFormat($chunked_arr);
    
            $document->name = $request->input('title');
            $document->schema = json_encode($formatedArr);
            $document->document_type = $request->input('document_type');
            $document->save();
            $request->session()->flash('message',translateMessage('messages.document_updated'));
        }

        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document, Request $request)
    {
        // return $document;
        if ($document) {
            // $document->delete();
            // $message =translateMessage('messages.document_deleted');
             $customer_docs = CustomerDocument::where('document_id', $document->id)->get();
            if (count($customer_docs) > 0) {
                $message =translateMessage('messages.unable_to_delete_document');
             
            } else {
                $document->delete();
                $message =translateMessage('messages.document_deleted');
            }
        } else {
            $message =translateMessage('messages.document_not_found');
        }

        $request->session()->flash("message", $message);
        return redirect()->route('documents.index');
    }
}
