<?php

namespace App\DataTables;

use App\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CustomersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query
            ->withCount(['wallet as balance' => function ($q1) {
                $q1->select(DB::raw("IFNULL(SUM(amount), 0) as balance"))->where('user_type', 'App\Customer');
            }])
            ->withCount('orders as all_orders');
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('first_name', $order);
            })
            ->addColumn('total_transaction', function ($query) {
                return $query->transaction();
            })
            ->addColumn('email_verified_at', function ($query) {
                return !empty($query->email_verified_at) ? Carbon::parse($query->email_verified_at)->format('Y-m-d'): '-';
            })
            ->addColumn('last_login', function ($query) {
                return !empty($query->last_login) ? Carbon::parse($query->last_login)->format('Y-m-d H:i:00') : '-';
            })
            ->addColumn('name', function ($query) {
                return '<strong>' . $query->first_name . ' ' . $query->last_name . '</strong>';
            })
            ->addColumn('gender', function ($query) {
                if ($query->gender == "Male") {
                  return   translateMessage('customer.Male');
                }
                if($query->gender == "Female") {
                    return   translateMessage('customer.Female');

                }
                if($query->gender == "Other") {
                    return   translateMessage('customer.Other');

                }
                
                
            })
            ->addColumn('edit', function ($query) {
                return '<a href="' . route('customers.edit', $query->id) . '" class="btn btn-primary"> '.translateMessage('common.edit').'</a>';
            })
            ->addColumn('delete', function ($query) {
                return '<form action="' . route('customers.destroy', $query->id) . '" onsubmit="return confirm(\''.translateMessage('common.deleteConfirm').'\')" method="POST"> <input type="hidden" name="_method" value="DELETE"> <input type="hidden" name="_token" value="' . csrf_token() . '"> <button class="btn btn-danger">'
                .translateMessage('common.delete').'</button> </form>';
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('first_name', 'like', '%' . $keyword . '%');
                $query->orWhere('last_name', 'like', '%' . $keyword . '%');
            })
            ->rawColumns(['name', 'delete', 'edit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Customer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Customer $model)
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
            ->setTableId('customers-table')
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
        return [
            Column::make('Sr#')
                ->name('id')
                ->data('id'),
            Column::make(translateMessage('common.name'))
                ->name('name')
                ->data('name'),
            Column::make(translateMessage('customer.account'))
                ->name('account_no')
                ->data('account_no'),
            Column::make(translateMessage('customer.email'))
            ->name('email')
            ->data('email'),
            Column::make(translateMessage('customer.gender'))
            ->name('gender')
            ->data('gender'),
            Column::make(translateMessage('customer.nationality'))
            ->name('nationality')
            ->data('nationality'),
            Column::make(translateMessage('customer.phone_no'))
            ->name('phone_no')
            ->data('phone_no'),
            Column::make(translateMessage('customer.MemberSince'))
                ->name('email_verified_at')
                ->data('email_verified_at'),


            Column::make(translateMessage('customer.LastSeen'))
                ->name('last_login')
                ->data('last_login'),
            Column::make(translateMessage('customer.Balance'))
                ->name('balance')
                ->data('balance')
                ->sortable(false),
            Column::make(translateMessage('customer.TotalOrders'))
                ->name('all_orders')
                ->data('all_orders'),
            Column::make(translateMessage('customer.TotalTransaction'))
                ->name('total_transaction')
                ->data('total_transaction'),
                
            Column::make(translateMessage('common.edit'))
                ->data('edit')
                ->exportable(false)
                ->printable(false)
                ->sortable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('common.delete'))
                ->data('delete')
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
        return 'Customers_' . date('YmdHis');
    }
}
