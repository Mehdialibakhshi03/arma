<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use jdavidbakr\MailTracker\Model\SentEmail;

class MailTrackerDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->editColumn('opened_at', function ($request) {
                if ($request->opened_at == '') {
                    return '-';
                } else {
                    return UtilityFacades::date_time_format($request->opened_at);
                }
            })->editColumn('clicked_at', function ($request) {
                if ($request->clicked_at == '') {
                    return '-';
                } else {
                    return UtilityFacades::date_time_format($request->clicked_at);
                }
            })->editColumn('created_at', function ($request) {
                return UtilityFacades::date_time_format($request->created_at);
            })
            ->addColumn('action', function (SentEmail $row) {
                return view('mailtracker.action', compact('row'));
            });
    }

    public function query(SentEmail $model)
    {
        $model = $model->newQuery();
        $search = session('mail-tracker-index-search');
        if ($search) {
            $terms = explode(" ", $search);
            foreach ($terms as $term) {
                $model->where(function ($q) use ($term) {
                    $q->where('sender_name', 'like', '%' . $term . '%')
                        ->orWhere('sender_email', 'like', '%' . $term . '%')
                        ->orWhere('recipient_name', 'like', '%' . $term . '%')
                        ->orWhere('recipient_email', 'like', '%' . $term . '%')
                        ->orWhere('subject', 'like', '%' . $term . '%');
                });
            }
        }
        return $model;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('index-table')
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(7)
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
            Column::make('DT_RowIndex')->title(__('No'))->orderable(false)->searchable(false),
            Column::make('recipient_email')->title(__('Recipient Email')),
            Column::make('subject')->title(__('Subject')),
            Column::make('opened_at')->title(__('Opened At')),
            Column::make('opens')->title(__('Opens')),
            Column::make('clicked_at')->title(__('Clicked At')),
            Column::make('clicks')->title(__('Clicks')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100),
        ];
    }

    protected function filename(): string
    {
        return 'MailTracker_' . date('YmdHis');
    }
}
