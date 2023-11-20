<?php

namespace App\DataTables;

use Modules\Setting\app\Models\Setting;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Facades\UtilityFacades;
use App\Models\Form;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;

class FormsDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->addColumn('status', function (Form $form) {
                $st = '';
                if ($form->is_active == 1) {
                    $st = '<span class="badge rounded-pill bg-success px-3 p-2">' . __("Active") . '</span>';
                } else {
                    $st = '<span class="badge rounded-pill bg-danger px-3 p-2">' . __("In Active") . '</span>';
                }
                return $st;
            })
            ->addColumn('action', function (Form $form) {
                $hashids = new Hashids();
                return view('admin.form.action', compact('form', 'hashids'));
            })->editColumn('created_at', function (Form $form) {
                return UtilityFacades::date_time_format($form->created_at->format('Y-m-d h:i:s'));
            })
            ->rawColumns(['status', 'location', 'action']);
    }
    public function query(Form $model)
    {
        return $model->newQuery();
        $usr = \Auth::user();
        $role_id = $usr->roles->first()->id;
        $user_id = $usr->id;

        if ($usr->type == 'Admin') {
            return $model->newQuery();
        } else {
            // dd($model);
            return $model->newQuery()
                ->where(function ($query) use ($role_id, $user_id) {
                    $query->whereIn('id', function ($query1) use ($role_id) {
                        $query1->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
                    })->OrWhereIn('id', function ($query1) use ($user_id) {
                        $query1->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
                    })->OrWhere('assign_type', 'public');
                });
            // $data = Form::where('created_by' , $usr->id)->get();
        }
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('forms-table')
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
                    [
                        'extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_module', 'action' => " function ( e, dt, node, config ) {
                        window.location = '" . route('admin.forms.create') . "';}"
                    ],
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
            ])->language([
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
            Column::make('status')->title(__('Status')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'Forms_' . date('YmdHis');
    }
}
