<?php

namespace App\DataTables;

use App\Facades\UtilityFacades;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use App\Models\FormValue;
use App\Models\User;

class FormValuesDataTable extends DataTable
{
    protected $status;
    public function __construct()
    {
        $this->status=session('formValueStatus');
    }

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn('DT_RowIndex')
            ->addColumn('user', function (FormValue $formValue) {
                $tu = '';
                if ($formValue->User) {
                    $tu = $formValue->User->name;
                }
                return $tu;
            })

            ->editColumn('form', function (FormValue $formValue) {
                $out=$formValue->Form->title;
                return $out;
            })
            ->editColumn('status', function (FormValue $formValue) {
                $status=$formValue->Status->title;
                return $status;
            })
            ->editColumn('created_at', function (FormValue $formValue) {
                return UtilityFacades::date_time_format($formValue->created_at);
            })
            ->editColumn('user', function (FormValue $formValue) {
                $username =  User::where('id', $formValue->user_id)->first();
                $user = ($formValue->user_id) ? $username->name : 'Guest';
                return $user;
            })
            ->addColumn('action', function (FormValue $formValue) {
                return view('admin.form_value.action', compact('formValue'));
            })
            ->rawColumns(['status', 'action', 'user', 'type', 'created_at']);
    }

    public function query(FormValue $model, Request $request)
    {

        $usr = \Auth::user();
        $user_id = $usr->id;
        if ($usr->hasRole('Seller')) {
//            $form_values =  $model->newQuery()
//                ->select(['form_values.*', 'forms.title'])
//                ->join('forms', 'forms.id', '=', 'form_values.form_id')
//                ->where(function ($query1) use ($role_id, $user_id) {
//                    $query1->whereIn('form_values.form_id', function ($query) use ($role_id) {
//                        $query->select('form_id')->from('assign_forms_roles')->where('role_id', $role_id);
//                    })->orWhereIn('form_values.form_id', function ($query) use ($user_id) {
//                            $query->select('form_id')->from('assign_forms_users')->where('user_id', $user_id);
//                        })->OrWhere('assign_type', 'public');
//                });
            if ($this->status==2){
                $form_values =  $model->where('status', $this->status)->where('user_id',$user_id);
            }else{
                $form_values =  $model->where('status','!=',2)->where('user_id',$user_id);
            }

        } else {
            if ($this->status==2) {
                $form_values = FormValue::where('status' ,$this->status)->select(['form_values.*', 'forms.title'])
                    ->join('forms', 'forms.id', '=', 'form_values.form_id')
                    ->leftJoin('users', 'users.id', 'form_values.user_id');
            }else{
                $form_values = FormValue::where('status','!=' ,2)->select(['form_values.*', 'forms.title'])
                    ->join('forms', 'forms.id', '=', 'form_values.form_id')
                    ->leftJoin('users', 'users.id', 'form_values.user_id');
            }


        }
//        $form_values = FormValue::where('status', $this->status)->select(['form_values.*', 'forms.title'])
//               ->join('forms', 'forms.id', '=', 'form_values.form_id')
//               ->leftJoin('users', 'users.id', 'form_values.user_id');
        if ($request->start_date && $request->end_date) {
            $form_values->whereBetween('form_values.created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->form) {
            $form_values->where('form_values.form_id', '=', $request->form);
        }

        return $form_values;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('forms-table')
            ->addIndex()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3)
            ->language([
                "paginate" => [
                    "next" => '<i class="fas fa-angle-right"></i>',
                    "previous" => '<i class="fas fa-angle-left"></i>'
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
            ['name' => 'id', 'title' => 'no', 'data' => "DT_RowIndex"],
            Column::make('user')->title(__('User')),
            Column::make('form')->title(__('Form')),
            Column::make('status')->title(__('status')),
//            Column::make('amount')->title(__('Amount')),
//            Column::make('transaction_id')->title(__('Transaction Id')),

//            Column::make('payment_type')->title(__('Payment Type')),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end'),
        ];
    }

    protected function filename(): string
    {
        return 'FormValues_' . date('YmdHis');
    }
}
