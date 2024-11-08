<?php

namespace App\DataTables;

use App\Service;
use App\Document;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ServicesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            //->OrderBy('id', 'desc')
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('service_detail', function ($query) {
                return ($query->service_detail) ? substr($query->service_detail, 0, 30) . '...' : "-";
            })
            ->addColumn('document_templates', function ($query) {
                $requirement_document_name = '';
                foreach(getDocumentListArray($query->formbuilder_id) as $document){
                    $document_object = Document::find($document);
                    $requirement_document_name .= "<span class='badge badge-info ml-1'>$document_object->name</span>";
                }
                return $requirement_document_name;
            })
            ->addColumn('category.name', function ($query) {
                // return $query;
                if (isset($query->category->name)) {
                    return $query->category->name;
                }
                return '----';
            })
            ->filterColumn('category.name', function($query, $keyword) {
                $query->where("name",'like', "$keyword%")->orwhere("id", $keyword);
            })
            
            ->addColumn('department.name', function ($query) {
                if (isset($query->department->name)) {
                    return $query->department->name;
                }
                return '----';
            })
            // ->filterColumn('department.name', function($query, $keyword) {
            //     $query->where("name",'like', "$keyword%")->orwhere("id", $keyword);
            // })
            ->addColumn('edit', function ($query) {
                return '<a href="' . route('service.edit', $query->id) . '" class="btn btn-primary"> Edit</a>';
            })
            ->addColumn('delete', function ($query) {
                return '<form action="' . route('service.destroy', $query->id) . '" onsubmit="return confirm(\'Are you sure to delete?\')" method="POST"> <input type="hidden" name="_method" value="DELETE"> <input type="hidden" name="_token" value="' . csrf_token() . '"> <button class="btn btn-danger">Delete</button> </form>';
            })
            ->rawColumns(['delete', 'edit',"document_templates"]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Service $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model)
    {
        return $model->with(['department','category'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('services-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->buttons(
                Button::make()
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('Sr#')
                ->name('id')
                ->data('id')
                ->searchable(false),
            Column::make('name'),
            Column::make('department')
                ->name('department.name')
                ->data('department.name'),
            Column::make('Main Category')
                ->name('category.name')
                ->sortable(false)
                ->data('category.name'),
              
            Column::make('document_templates'),
            Column::make('service_detail'),
            Column::make('fee'),
            Column::make('edit')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('delete')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Services_' . date('YmdHis');
    }
}
