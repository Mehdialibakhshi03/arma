<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use App\Models\SmsTemplate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmsTemplateDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
        ->eloquent($query)
        ->addIndexColumn()
        ->editColumn('created_at', function (SmsTemplate $row) {
            return UtilityFacades::date_time_format($row->created_at);
        })
        ->addColumn('action', function (SmsTemplate $row) {
            return view('sms_template.action', compact('row'));
        })
        ->rawColumns(['action']);
    }

    public function query(SmsTemplate $model): QueryBuilder
    {
        return $model->newQuery();
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
                "next" => '<i class="fas fa-angle-right"></i>',
                "previous" => '<i class="fas fa-angle-left"></i>'
            ]
        ])
        ->parameters([
            "dom" =>  "
                            <'row'<'col-sm-12 p-0'><'col-sm-9 text-left'B><'col-sm-3'f>>
                            <'row'<'col-sm-12'tr>>
                            <'row align-items-center mt-3'<'col-sm-5'i><'col-sm-7'p>>
                            ",
            'buttons'   => [
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
                  });
            }'
        ])->language([
            'buttons'=>[
                'create'=>__('Create'),
                'export'=>__('Export'),
                'print'=>__('Print'),
                'reset'=>__('Reset'),
                'reload'=>__('Reload'),
                'excel'=>__('Excel'),
                'csv'=>__('CSV'),
                'pageLength'=>__('Show %d rows'),
            ]
        ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('event')->title(__('Event')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(100),
        ];
    }

    protected function filename(): string
    {
        return 'SmsTemplate_' . date('YmdHis');
    }
}
