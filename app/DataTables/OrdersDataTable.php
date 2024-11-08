<?php

namespace App\DataTables;

use App\Order;
use League\CommonMark\Inline\Element\Strong;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use Session;
class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $q = $query->with('customer')->with('group')->with('department')->with('category')->with('service')->with('status');
        // Add Status filter
        if (isset($_GET['status'])) {
            $q->where('status_id', trim($_GET['status']));
        }
        return datatables()
            ->eloquent($q)
            ->addIndexColumn()
            ->addColumn('customer', function ($query) {
                if ($query->customer  ) {
                    return '<strong>' . $query->customer->first_name . ' ' . $query->customer->last_name . '</strong>';

                }
            })
            ->addColumn('status', function ($query) {
                return '<span class="' . $query->status->class . ' text-uppercase">' .translateMessage( "customer.".$query->status->name). '</span>';
            })
            ->addColumn('requirements', function ($query) {
                $html = '<button class="d-none showRequirementsModal" data-target="#requirementsModal" data-toggle="modal"></button>';
                $html .= '<a href="#" class="btn btn-warning btn-sm btnShowRequirements"title="Show Requirement Details" data-id="' . $query->id . '"><i class="cil-file"></i></a>';
                return $html;
            })
            ->addColumn('view', function ($query) {
                $html = '<button class="d-none viewOrderDetailModal" data-toggle="modal" data-target="#viewOrderDetailModal"></button>';
                $html .= '<a href="#" class="btn btn-success btn-sm btnShowOrderDetail" title="View Order Detail" data-id="' . $query->id . '"><i class="fas fa-eye"></i></a>';
                return $html;
            })
            ->addColumn('transaction', function ($query) {
                $html = '<button class="d-none showTransactionModal" data-toggle="modal" data-target="#transactionsModal"></button>';
                $html .= '<a href="#" class="btn btn-info btn-sm btnShowTransaction" title="Show Transaction" data-id="' . $query->id . '"><i class="cil-credit-card"></i></a>';
                return $html;
            })
            ->addColumn('message', function ($query) {
                $html = '<button class="d-none showMessageModal" data-target="#messagesModal" data-toggle="modal"></button>';
                $html .= '<a href="#" class="btn btn-secondary btn-sm btnShowMessages" title="Notifications"
                data-id="' . $query->id . '">
                <i class="cil-bell c-icon"></i>
                <span
                    class="badge badge-pill badge-danger">' . $query->getUnreadMessageCount("App\Customer") . '</span>
            </a>';
                return $html;
            })
            ->addColumn('edit', function ($query) {
                if ($query->status_id == '4' || $query->status_id == '5') {
                    return '<button class="btn btn-sm btn-primary" disabled><i class="cil-pencil c-icon"></i></button>';
                } else {
                    return '<a href="' . route('order.edit', $query->id) . '" class="btn btn-sm btn-primary"><i class="cil-pencil c-icon" title="Edit Order Status"></i>
                    </a>';
                }
            })
            ->editColumn('created_at', function ($query) {
                // $date = Carbon::parse($query->created_at);
                // $date->format('Y-m-d h:i:s A');
             
                // return  $date->isoFormat('Y-m-d h:mm:s a');

                $time = date('h:i:s a',strtotime($query->created_at));
                //  $convertedtime = Carbon::parse($time)->isoFormat('h:mm A');
                 return date('Y-m-d ', strtotime($query->created_at)).  $time;

            })
            ->addColumn('group', function ($query) {
                return ($query->group) ? $query->group->name : "-";
            })
            ->filterColumn('status', function ($query, $keyword) {
                $query->whereHas('status', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('group', function ($query, $keyword) {
                $query->whereHas('group', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('customer', function ($query, $keyword) {
                $query->whereHas('customer', function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%');
                    $q->orWhere('last_name', 'like', '%' . $keyword . '%');
                });
            })
            ->rawColumns(['message', 'view', 'transaction', 'status', 'requirements', 'customer', 'edit']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
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
            ->setTableId('orders-table')
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
            Column::make(translateMessage('order.order_no'))
            ->name('order_no')
            ->data('order_no'),
            Column::make(translateMessage('order.customer'))
            ->name('customer')
            ->data('customer'),
            Column::make(translateMessage('group.group'))
            ->name('group')
            ->data('group'),
            Column::make(translateMessage('department.department'))
            
                ->name('department.name')
                ->data('department.name'),
            Column::make(translateMessage('order.category'))
                ->name('category.name')
                ->data('category.name'),
            Column::make(translateMessage('order.service'))
                ->name('service.name')
                ->data('service.name'),
            Column::make(translateMessage('order.agreed_fee'))
            ->name('agreed_fee')
            ->data('agreed_fee'),
            Column::make(translateMessage('order.status'))
            ->name('status')
            ->data('status'),
            Column::make(translateMessage('order.created_at'))
            ->name('created_at')
            ->data('created_at'),
            Column::make('')
                ->name('view')
                ->data('view')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('transaction')
                ->data('transaction')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('message')
                ->data('message')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('requirements')
                ->data('requirements')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('edit')
                ->data('edit')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
        ]:[
            Column::make('')
                ->name('edit')
                ->data('edit')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('requirements')
                ->data('requirements')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('message')
                ->data('message')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('transaction')
                ->data('transaction')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('')
                ->name('view')
                ->data('view')
                ->exportable(false)
                ->sortable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make(translateMessage('order.created_at'))
                ->name('created_at')
                ->data('created_at'),
            Column::make(translateMessage('order.status'))
                ->name('status')
                ->data('status'),
            Column::make(translateMessage('order.agreed_fee'))
                ->name('agreed_fee')
                ->data('agreed_fee'),
            Column::make(translateMessage('order.service'))
                ->name('service.name')
                ->data('service.name'),
            Column::make(translateMessage('order.category'))
                ->name('category.name')
                ->data('category.name'),
            Column::make(translateMessage('department.department'))

                ->name('department.name')
                ->data('department.name'),
            Column::make(translateMessage('group.group'))
                ->name('group')
                ->data('group'),
            Column::make(translateMessage('order.customer'))
                ->name('customer')
                ->data('customer'),
            Column::make(translateMessage('order.order_no'))
                ->name('order_no')
                ->data('order_no'),
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
        return 'Orders_' . date('YmdHis');
    }
}
