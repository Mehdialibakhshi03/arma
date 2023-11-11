<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\DashboardWidget;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DashboardWidgetDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('type', function (DashboardWidget $dashboard) {
                return ucfirst($dashboard->type);
            })
            ->editColumn('form_id', function (DashboardWidget $dashboard) {
                return ($dashboard->Form) ? $dashboard->Form->title : '';
            })
            ->editColumn('poll_id', function (DashboardWidget $dashboard) {
                return ($dashboard->Poll) ? $dashboard->Poll->title : '';
            })
            ->editColumn('chart_type', function (DashboardWidget $dashboard) {
                return ucfirst($dashboard->chart_type);
            })
            ->editColumn('field_name', function (DashboardWidget $dashboard) {
                if (property_exists($dashboard, 'name')) {
                    $name = '';
                    if ($dashboard->Form) {
                        $field_name = json_decode($dashboard->Form->json);
                        foreach ($field_name[0] as $val) {
                            if ($val->name ==  $dashboard->field_name) {
                                $name = $val->label;
                            }
                        }
                    }
                    return $name;
                }
            })
            ->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->addColumn('action', function (DashboardWidget $dashboard) {
                return view('dashboard.action', compact('dashboard'));
            })
            ->rawColumns(['action', 'form_id', 'poll_id', 'field_name', 'chart_type']);
    }

    public function query(DashboardWidget $model)
    {
        $widget =  $model->newQuery();
        $widget->orderBy('position');
        return $widget;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('dashboard_widgets-table')
            ->addIndex()
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
                "dom" =>  "<'row'<'col-sm-12'><'col-sm-9 text-left'B><'col-sm-3'f>>
                <'row'<'col-sm-12'tr>>
                <'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_dashboard', 'action' => " function ( e, dt, node, config ) {}"],
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

    protected function getColumns()
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('title')->title(__('Title')),
            Column::make('size')->title(__('Size')),
            Column::make('type')->title(__('Type')),
            Column::make('chart_type')->title(__('Chart Type')),
            Column::make('position')->title(__('Position')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->width('20%'),
        ];
    }

    protected function filename(): string
    {
        return 'DashboardWidget_' . date('YmdHis');
    }
}
