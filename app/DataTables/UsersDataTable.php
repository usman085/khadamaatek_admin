<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Session;

class UsersDataTable extends DataTable
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
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('menuroles', function ($query) {
                $menuroles = '';
                if(!empty($query->menuroles)){
                    $role_array = explode(',', $query->menuroles);
                    foreach($role_array as $role){
                        $menuroles = $menuroles . '<span class="badge badge-info">'.$role.'</span>';
                    }
                }
                return $menuroles;
            })
            ->addColumn('email_verified_at', function ($query) {
                if(!empty($query->email_verified_at)){
                    return 'Verified';
                }
                return 'Not Verified';
            })
            ->addColumn('edit', function ($query) {
                return '<a href="' . route('users.edit', $query->id) . '" class="btn btn-primary">' .translateMessage('common.edit').'</a>';
            })
            ->addColumn('delete', function ($query) {
                $you = auth()->user();
                if( $you->id !== $query->id ){
                    return '<form action="' . route('users.destroy', $query->id) . '" method="POST"> 
                    <input type="hidden" name="_method" value="DELETE"> 
                    <input type="hidden" name="_token" value="' . csrf_token() . '"> 
                    <button class="btn btn-danger">'.translateMessage('common.delete').'</button> 
                    </form> 
                    <div id="confirmBox">
                    <div class="message"></div>
                    <div class="cover">
                    <button class="button btn btn-primary  yes">'.translateMessage('common.Ok').'</button>
                    <button class="button btn btn-danger no ">'.translateMessage('common.Cancel').'</button>
    
                    </div>
                    </div>
                    ';
                }
                return '';
            })
            ->rawColumns(['menuroles', 'delete', 'edit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
            ->setTableId('usersdatatable-table')
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
        return $lang=="en"? [
            Column::make(translateMessage('setting.username'))
                ->name('name')
                ->data('name'),
            Column::make(translateMessage('setting.email'))
                ->name('email')
                ->data('email'),
            Column::make(translateMessage('setting.phoneNo'))
                ->name('phone_no')
                ->data('phone_no'),
            Column::make(translateMessage('setting.roles'))
                ->name('menuroles')
                ->sortable(false)
                ->data('menuroles'),
            Column::make(translateMessage('setting.emailVerified'))
                ->name('email_verified_at')
                ->sortable(false)
                ->data('email_verified_at'),
            Column::make(translateMessage('common.edit'))
                 ->data('edit')
                ->exportable(false)
                ->printable(false)
                ->sortable(false)
                ->searchable(false)
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
                ->data('edit')
                ->exportable(false)
                ->printable(false)
                ->sortable(false)
                ->searchable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('setting.emailVerified'))
                ->name('email_verified_at')
                ->sortable(false)
                ->data('email_verified_at'),
            Column::make(translateMessage('setting.roles'))
                ->name('menuroles')
                ->sortable(false)
                ->data('menuroles'),
            Column::make(translateMessage('setting.phoneNo'))
                ->name('phone_no')
                ->data('phone_no'),
            Column::make(translateMessage('setting.email'))
                ->name('email')
                ->data('email'),
            Column::make(translateMessage('setting.username'))
                ->name('name')
                ->data('name'),






        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
