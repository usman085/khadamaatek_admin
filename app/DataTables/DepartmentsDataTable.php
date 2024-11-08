<?php

namespace App\DataTables;

use App\Department;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Session;

class DepartmentsDataTable extends DataTable
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
            ->eloquent($query->with('group'))
            ->addIndexColumn()
            ->addColumn('edit', function ($query) {
                return '<a href="' . route('department.edit', $query->id) . '" class="btn btn-primary"> '.translateMessage('common.edit').'</a>';
            })
            ->addColumn('delete', function ($query) {
                return '<form class="form"  action="' . route('department.destroy', $query->id) . '"
                 method="POST"> 
                <input type="hidden" name="_method" value="DELETE"> <input type="hidden"
                 name="_token" value="' . csrf_token() . '"> 
                 <button class="btn btn-danger">'
                 .translateMessage('common.delete').'</button> </form>
                 <div id="confirmBox">
                 <div class="message"></div>
                 <div class="cover">
                 <button class="button btn btn-primary  yes">'.translateMessage('common.Ok').'</button>
                 <button class="button btn btn-danger no ">'.translateMessage('common.Cancel').'</button>
 
                 </div>
                 </div>
                 
                 ';
            })
            ->rawColumns(['delete', 'edit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Department $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Department $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('departments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
            ->parameters([
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/'.translateMessage('common.lang').'.json']
                ])
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
        $lang = Session::get('current_locale','en');
        return $lang=="en"?[
            Column::make('Sr#')
                ->name('id')
                ->data('id'),
            Column::make(translateMessage('group.name'))
                ->name('name')
                ->data('name'),
            Column::make(translateMessage('group.group'))
                ->data('group.name')
                ->sortable(false)
                ->name('group.name'),
            Column::make(translateMessage('common.edit'))
                ->name('edit')
                ->data('edit')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('common.delete'))
                ->data('delete')
                ->sortable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ]:[
            Column::make(translateMessage('common.delete'))
                ->data('delete')
                ->sortable(false)
                ->searchable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('common.edit'))
                ->name('edit')
                ->data('edit')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('group.group'))
                ->data('group.name')
                ->sortable(false)
                ->name('group.name'),
            Column::make(translateMessage('group.name'))
                ->name('name')
                ->data('name'),
            Column::make('Sr#')
                ->name('id')
                ->data('id'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Departments_' . date('YmdHis');
    }
}
