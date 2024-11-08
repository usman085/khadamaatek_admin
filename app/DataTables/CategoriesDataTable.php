<?php

namespace App\DataTables;

use App\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
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
            ->eloquent($query->whereNull('parent_id')->with('department')->with('department.group'))
            ->addIndexColumn()
            ->addColumn('view', function ($query) {
                return '<a href="' . route('category.childs', $query->id) . '" class="btn btn-primary"> View Childs</a>';
            })
            ->addColumn('department.name', function ($query) {
                if (isset($query->department->name)) {
                    return $query->department->name;
                }
                return '----';
            })
            ->addColumn('department.group.name', function ($query) {
                if (isset($query->department->group->name)) {
                    return $query->department->group->name;
                }
                return '----';
            })
            ->addColumn('edit', function ($query) {
                return '<a href="' . route('category.edit', $query->id) . '" class="btn btn-primary"> Edit</a>';
            })
            ->addColumn('delete', function ($query) {
                return '<form action="' . route('category.destroy', $query->id) . '" onsubmit="return confirm(\'Are you sure to delete?\')" method="POST"> <input type="hidden" name="_method" value="DELETE"> <input type="hidden" name="_token" value="' . csrf_token() . '"> <button class="btn btn-danger">Delete</button> </form>';
            })
            ->rawColumns(['view', 'delete', 'edit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
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
            ->setTableId('categories')
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
                ->data('id'),
            Column::make('name'),
            Column::make('department')
                ->data('department.name')
                ->sortable(false)
                ->name('department.name'),
                Column::make('group')
                ->data('department.group.name')
                ->sortable(false)
                ->name('department.group.name'),
            Column::make('view')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('edit')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('delete')
                ->sortable(false)
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
        return 'Categories_' . date('YmdHis');
    }
}