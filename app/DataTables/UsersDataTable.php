<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    protected $type;

    public function __construct($type)
    {
        $this->type=$type;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->editColumn('active_status', function (User $user) {
                if ($user->active_status == 1) {
                    return '<span class="badge rounded-pill bg-success p-2 px-3">' . __('Active') . '</span>';
                } else {
                    return '<span class="badge rounded-pill bg-danger p-2 px-3">' . __('Deactive') . '</span>';
                }
            })
            ->addColumn('role', function (User $user) {
                $out = '';
                $out = '<span class="badge rounded-pill bg-primary px-3 p-2">' . $user->type . '</span>';
                return $out;
            })
            ->addColumn('email_verified_at', function (User $user) {
                if ($user->email_verified_at) {
                    $out = '<span class="badge rounded-pill bg-info px-3 p-2">' . __('Verified') . '</span>';
                    return $out;
                } else {
                    $out = '<span class="badge rounded-pill bg-warning px-3 p-2">' . __('Unverified') . '</span>';
                    return $out;
                }
            })
            ->addColumn('phone_verified_at', function (User $user) {
                if ($user->phone_verified_at) {
                    $out = '<span class="badge rounded-pill bg-info px-3 p-2">' . __('Verified') . '</span>';
                    return $out;
                } else {
                    $out = '<span class="badge rounded-pill bg-warning px-3 p-2">' . __('Unverified') . '</span>';
                    return $out;
                }
            })
            ->addColumn('action', function (User $user) {
                return view('users.action', compact('user'));
            })
            ->rawColumns(['role', 'email_verified_at', 'action', 'active_status', 'phone_verified_at']);
    }

    public function query(User $model): QueryBuilder
    {
        $type=$this->type;
        return $model->newQuery()->where('id', '!=', 1)->where('active_status',$type)->orderBy('id', 'ASC');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ]
            ])
            ->parameters([
                "dom" => "<'row'<'col-sm-12'><'col-sm-9 text-left'B><'col-sm-3'f>>
            <'row'<'col-sm-12'tr>>
            <'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                'buttons' => [
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_user', 'action' => " function ( e, dt, node, config ) {}"],
                    ['extend' => 'export', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'pageLength', 'className' => 'btn btn-primary btn-sm no-corner',],
                ],
                "scrollX" => true,
                "drawCallback" => 'function( settings ) {
                var tooltipTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=tooltip]")
                  );
                  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                  });
                  var popoverTriggerList = [].slice.call(
                    document.querySelectorAll("[data-bs-toggle=popover]")
                  );
                  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl);
                  });
                  var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                  var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                  }
                );
            }'
            ])
            ->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                    'pageLength' => __('Show %d rows'),
                ]
            ]);
    }

    protected function getColumns(): array
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('email')->title(__('Email')),
            Column::make('role')->title(__('Role')),
            Column::make('active_status')->title(__('Status')),
            Column::make('email_verified_at')->title(__('Email Verified At')),
            Column::make('phone_verified_at')->title(__('Phone Verified At')),
            // Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}

