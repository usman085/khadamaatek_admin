<?php

namespace App\DataTables;

use App\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Session;

class TransactionsDataTable extends DataTable
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
            ->eloquent($query->with('from_customer')->with('to_customer')->with('from_user')->with('to_user'))
            ->addIndexColumn()
            ->addColumn('from_name', function ($query) {
                if ($query->from_type == 'App\User') {
                    return !empty($query->from_user) ? $query->from_user->name : '-';
                } else {
                    return ($query->from_customer) ? $query->from_customer->first_name . ' ' . $query->from_customer->last_name : "-";
                }
            })
            ->addColumn('from_phone', function ($query) {
                if ($query->from_type == 'App\User') {
                    return !empty($query->from_user) ? $query->from_user->phone_no : '-';
                } else {
                    return ($query->from_customer) ? $query->from_customer->phone_no : "-";
                }
            })
            ->addColumn('to_name', function ($query) {
                if ($query->to_type == 'App\User') {
                    return !empty($query->to_user) ? $query->to_user->name : '-';
                } else {
                    return ($query->to_customer) ? $query->to_customer->first_name . ' ' . $query->to_customer->last_name : "-";
                }
            })
            ->addColumn('to_phone', function ($query) {
                if ($query->to_type == 'App\User') {
                    return !empty($query->to_user) ? $query->to_user->phone_no : '-';
                } else {
                    return ($query->to_customer) ? $query->to_customer->phone_no : "-";
                }
            })
            ->editColumn('created_at', function ($query) {
                return date('Y-m-d h:i:s A', strtotime($query->created_at));
            })
            ->editColumn('updated_at', function ($query) {
                return date('Y-m-d h:i:s A', strtotime($query->updated_at));
            })

            
            ->addColumn('attachment', function ($query) {
                if ($query->attachment) {
                    $html = '<a href="/transactions/' . $query->attachment . '" target="_blank" class="btn btn-warning btn-sm"><i class="cil-file"></i></a>';
                } else {
                    $html = '<button class="btn btn-warning btn-sm"><i class="cil-file"></i></button>';
                }
                return $html;
            })
            ->addColumn('edit', function ($query) {
                if ($query->status == 'Cancelled' || $query->status == 'Verified') {
                    return '<button class="btn btn-sm btn-primary" disabled> <i class="cil-pencil"></i></button>';
                } else {
                    return '<a href="' . route('transaction.edit', $query->id) . '" class="btn btn-sm btn-primary"> <i class="cil-pencil"></i></a>';
                }
            })
            ->addColumn('status', function ($query) {
                if ( $query->status == 'Verified') {
                    return '<div class="chip">'.translateMessage('setting.verified').'</div>';
                } 
                elseif ($query->status == 'Cancelled') {
                    return '<div class="cancel">'.translateMessage('setting.cancelled').'</div>';

                }
                else {
                    return "----";
                }
            })

            ->addColumn('etype', function ($query) {
             
                    return translateMessage('setting.'.$query->etype);
                
            })

            ->filterColumn('from_name', function ($query, $keyword) {
                $query->whereHas('from_user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('from_customer', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%');
                    $q->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('to_name', function ($query, $keyword) {
                $query->whereHas('to_user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                })->orWhereHas('to_customer', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%');
                    $q->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['attachment', 'edit','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Transaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
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
            ->setTableId('transactions-table')
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
            Column::make('Sr#')
                ->name('id')
                ->data('id')
                ->searchable(false),
            Column::make(translateMessage('order.fromAcc'))
                ->name('from_acc_id')
                ->data('from_acc_id'),
            Column::make(translateMessage('transaction.from_name'))
            ->name('from_name')
            ->data('from_name'),
              
            Column::make(translateMessage('transaction.from_phone'))
            ->name('from_phone')
            ->data('from_phone'),
        
            Column::make(translateMessage('order.toAcc'))
                ->name('to_acc_id')
                ->data('to_acc_id'),
            Column::make(translateMessage('transaction.to_name'))
            ->name('to_name')
            ->data('to_name'),
            Column::make(translateMessage('transaction.to_phone'))
            ->name('to_phone')
            ->data('to_phone'),
            Column::make(translateMessage('order.ammount'))
            ->name('amount')
            ->data('amount'),
            Column::make(translateMessage('order.status'))
            ->name('status')
            ->data('status')
            ->sortable(false)
            ->exportable(false)
            ->printable(false)
            ->addClass('text-center'),
            Column::make(translateMessage('transaction.type'))
                ->name('etype')
                ->data('etype'),
            Column::make(translateMessage('order.created_at'))
            ->name('created_at')
            ->data('created_at'),
            Column::make(translateMessage('transaction.updated_at'))
            ->name('updated_at')
            ->data('updated_at'),
         
            Column::make('')
                ->name('attachment')
                ->data('attachment')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('edit')
                ->data('edit')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ]:[
            Column::make('')
                ->name('edit')
                ->data('edit')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('attachment')
                ->data('attachment')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('transaction.updated_at'))
                ->name('updated_at')
                ->data('updated_at'),
            Column::make(translateMessage('order.created_at'))
                ->name('created_at')
                ->data('created_at'),
            Column::make(translateMessage('transaction.type'))
                ->name('etype')
                ->data('etype'),
            Column::make(translateMessage('order.status'))
                ->name('status')
                ->data('status')
                ->sortable(false)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('order.ammount'))
                ->name('amount')
                ->data('amount'),
            Column::make(translateMessage('transaction.to_phone'))
                ->name('to_phone')
                ->data('to_phone'),
            Column::make(translateMessage('transaction.to_name'))
                ->name('to_name')
                ->data('to_name'),
            Column::make(translateMessage('order.toAcc'))
                ->name('to_acc_id')
                ->data('to_acc_id'),
            Column::make(translateMessage('transaction.from_phone'))
                ->name('from_phone')
                ->data('from_phone'),
            Column::make(translateMessage('transaction.from_name'))
                ->name('from_name')
                ->data('from_name'),
            Column::make(translateMessage('order.fromAcc'))
                ->name('from_acc_id')
                ->data('from_acc_id'),
            Column::make('Sr#')
                ->name('id')
                ->data('id')
                ->searchable(false),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transactions_' . date('YmdHis');
    }
}
