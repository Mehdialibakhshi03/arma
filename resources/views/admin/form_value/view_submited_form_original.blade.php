@extends('admin.layouts.main')
@section('title', __('Submitted Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Submitted Forms of ' . ' ' . $forms_details->title) }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Submitted Forms of ' . ' ' . $forms_details->title) }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content">
            <section class="section">
                @if (!empty($forms_details->logo))
                    <div class="text-center gallery gallery-md">
                        {!! Form::image(
                            Storage::exists($forms_details->logo)
                                ? asset('storage/app/' . $forms_details->logo)
                                : Storage::url('uploads/appLogo/78x78.png'),
                            null,
                            [
                                'class' => 'gallery-item float-none',
                                'id' => 'app-dark-logo',
                            ],
                        ) !!}
                    </div>
                @endif
                <h2 class="text-center">{{ $forms_details->title }}</h2>
                <div class="section-body filter">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="card p-3">
                                <div class="card-body">
                                    @can('manage-submitted-form')
                                        <div class="form-group text-end row justify-content-end">
                                            <div class="col-lg-3 col-md-3 col-sm-12 d-flex ">
                                                {{ Form::text('duration', null, ['class' => 'form-control mr-1', 'placeholder' => __('Select Date Range'), 'id' => 'pc-daterangepicker-1']) }}
                                                {!! Form::hidden('form_id', $forms_details->id, ['id' => 'form_id']) !!}
                                                {{ Form::button(__('Filter'), ['class' => 'btn btn-primary btn-lg ml-10 mr-17', 'id' => 'filter']) }}
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive py-4">
                                                {{ $dataTable->table(['width' => '100%']) }}
                                                {!! Form::open(['route' => ['admin.mass.export.csv'], 'method' => 'post', 'id' => 'mass_export']) !!}
                                                {{ Form::hidden('form_id', $forms_details->id) }}
                                                {{ Form::hidden('start_date') }}
                                                {{ Form::hidden('end_date') }}
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['admin.mass.export.xlsx'], 'method' => 'post', 'id' => 'mass_export_xlsx']) !!}
                                                {{ Form::hidden('form_id', $forms_details->id) }}
                                                {{ Form::hidden('start_date') }}
                                                {{ Form::hidden('end_date') }}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12" id="chart_div">
                                    <style>
                                        .pie-chart {
                                            width: 100%;
                                            height: 400px;
                                            margin: 0 auto;
                                            float: right;
                                        }

                                        .text-center {
                                            text-align: center;
                                        }

                                        @media (max-width: 991px) {
                                            .pie-chart {
                                                width: 100%;
                                            }
                                        }
                                    </style>
                                    <script src="{{ asset('assets/js/loader.js') }}"></script>
                                    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>
                                    <div class="row">
                                        @php($key = 1)
                                        @foreach ($chartData as $chart)
                                            <div class="col-lg-6  mb-3">
                                                @if ($chart['chart_type'] == 'bar')
                                                    <div id="chartDiv-{{ $key }}" class="pie-chart"></div>
                                                @endif
                                                @if ($chart['chart_type'] == 'pie')
                                                    <div id="chartDive-{{ $key }}" class="pie-chart"></div>
                                                @endif
                                            </div>
                                            <script type="text/javascript">
                                                function drawChart{{ $key }}() {
                                                    var data = new google.visualization.DataTable();
                                                    data.addColumn('string', 'Pizza');
                                                    data.addColumn('number', 'Populartiy');
                                                    data.addRows([
                                                        @foreach ($chart['options'] as $label => $count)
                                                            ['{{ $label }}', {{ $count }}],
                                                        @endforeach
                                                    ]);
                                                    var options = {
                                                        title: "{{ $chart['label'] }}",
                                                        sliceVisibilityThreshold: .0,
                                                    };
                                                    @if ($chart['chart_type'] == 'bar')
                                                        var chart = new google.visualization.ColumnChart(document.getElementById('chartDiv-{{ $key }}'));
                                                        chart.draw(data, options);
                                                    @endif
                                                    @if ($chart['chart_type'] == 'pie')
                                                        var chart = new google.visualization.PieChart(document.getElementById('chartDive-{{ $key }}'));
                                                        chart.draw(data, options);
                                                    @endif
                                                }
                                            </script>
                                            @php($key++)
                                        @endforeach
                                    </div>
                                    <script>
                                        window.onload = function() {
                                            google.load("visualization", "1.1", {
                                                packages: ["corechart"],
                                                callback: 'drawAllChart'
                                            });
                                        };

                                        function drawAllChart() {
                                            @php($key = 1)
                                            @foreach ($chartData as $chart)
                                                drawChart{{ $key }}();
                                                @php($key++)
                                            @endforeach
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script>
        // document.querySelector("#pc-daterangepicker-1").flatpickr({
        //     mode: "range"
        // });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    @include('admin.layouts.includes.datatable_js')
    {{-- {{ $dataTable->scripts() }} --}}
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'This is a placeholder set in the config',
                    searchPlaceholderValue: 'This is a search placeholder',
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", "#filter", function() {
                getData();
            });
            $(document).on("click", ".buttons-csv", function() {
                $("#mass_export input[name='start_date']").val($("#start_date1").val());
                $("#mass_export input[name='end_date']").val($("#end_date1").val());
                $("#mass_export").submit();
            })
            $(document).on("click", ".buttons-excel", function() {
                $("#mass_export_xlsx input[name='start_date']").val($("#start_date1").val());
                $("#mass_export_xlsx input[name='end_date']").val($("#end_date1").val());
                $("#mass_export_xlsx").submit();
            })
            window.LaravelDataTables = null;
            function getData() {
                if (window.LaravelDataTables == null) {
                    window.LaravelDataTables = $("#forms-table").DataTable({
                        "serverSide": true,
                        "processing": true,
                        "ajax": {
                            "url": "{{ route('admin.formvalues.index') }}",
                            "type": "GET",
                            "data": function(data) {
                                for (var i = 0, len = data.columns.length; i < len; i++) {
                                    if (!data.columns[i].search.value) delete data.columns[i].search;
                                    if (data.columns[i].searchable === true) delete data.columns[i]
                                        .searchable;
                                    if (data.columns[i].orderable === true) delete data.columns[i]
                                        .orderable;
                                    if (data.columns[i].data === data.columns[i].name) delete data
                                        .columns[i]
                                        .name;
                                }
                                // var filter = $('#pc-daterangepicker-1').val();
                                // var spilit = filter.split("to");
                                // delete data.search.regex;
                                // data.form = $("#form_id").val();
                                // data.start_date = spilit[0];
                                // data.end_date = spilit[1];
                            }
                        },
                        "columns": [{
                            "name": "id",
                            "title": "no",
                            "data": "DT_RowIndex",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "user",
                            "name": "user",
                            "title": "User",
                            "orderable": true,
                            "searchable": true
                        },
                        //     {
                        //     "data": "amount",
                        //     "name": "amount",
                        //     "title": "Amount",
                        //     "orderable": true,
                        //     "searchable": true
                        // },

                        //     {
                        //     "data": "transaction_id",
                        //     "name": "transaction_id",
                        //     "title": "Transaction Id",
                        //     "orderable": true,
                        //     "searchable": true
                        // },

                        //     {
                        //     "data": "status",
                        //     "name": "status",
                        //     "title": "Payment Status",
                        //     "orderable": true,
                        //     "searchable": true
                        // },

                        //     {
                        //     "data": "payment_type",
                        //     "name": "payment_type",
                        //     "title": "Payment Type",
                        //     "orderable": true,
                        //     "searchable": true
                        // },

                            {
                            "data": "created_at",
                            "name": "created_at",
                            "title": "Created At",
                            "orderable": true,
                            "searchable": true
                        }, {
                            "data": "action",
                            "name": "action",
                            "title": "Action",
                            "orderable": false,
                            "searchable": false,
                            "className": "text-end"
                        }],
                        "order": [
                            [3, "desc"]
                        ],
                        "language": {
                            "paginate": {
                                "next": "<i class=\"fas fa-angle-right\"><\/i>",
                                "previous": "<i class=\"fas fa-angle-left\"><\/i>"
                            },
                            "buttons": {
                                "create": "Create",
                                "export": "Export",
                                "print": "Print",
                                "reset": "Reset",
                                "reload": "Reload",
                                "excel": "Excel",
                                "csv": "CSV",
                                "pageLength": "Show %d rows"
                            }
                        },
                        "dom": "<'row'<'col-sm-12'><'col-sm-9 text-left'B><'col-sm-3'f>>\n                <'row'<'col-sm-12'tr>>\n                <'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                        "buttons": [
                        //     {
                        //     "extend": "export",
                        //     "className": "btn btn-primary btn-sm no-corner"
                        // }, {
                        //     "extend": "print",
                        //     "className": "btn btn-primary btn-sm no-corner"
                        // }, {
                        //     "extend": "reset",
                        //     "className": "btn btn-primary btn-sm no-corner"
                        // }, {
                        //     "extend": "reload",
                        //     "className": "btn btn-primary btn-sm no-corner"
                        // },
                            {
                            "extend": "pageLength",
                            "className": "btn btn-primary btn-sm no-corner"
                        }
                        ],

                        "scrollX": true,
                        "drawCallback": function(settings) {
                            var tooltipTriggerList = [].slice.call(
                                document.querySelectorAll("[data-bs-toggle=tooltip]")
                            );
                            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                            var popoverTriggerList = [].slice.call(
                                document.querySelectorAll("[data-bs-toggle=popover]")
                            );
                            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                                return new bootstrap.Popover(popoverTriggerEl);
                            });
                            var toastElList = [].slice.call(document.querySelectorAll(".toast"));
                            var toastList = toastElList.map(function(toastEl) {
                                return new bootstrap.Toast(toastEl);
                            });
                        }
                    });
                } else {
                    window.LaravelDataTables.ajax.reload();
                }
            }
            getData();
            $(function() {
                function cb(start, end) {
                    $("#duration1").val(start.format('MMM D, YY hh:mm A') + ' - ' + end.format(
                        'MMM D, YY hh:mm A'));
                    $('input[name="start_date1"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
                    $('input[name="due_date1"]').val(end.format('YYYY-MM-DD HH:mm:ss'));
                }
                $('#duration1').daterangepicker({
                    timePicker: true,
                    autoUpdateInput: false,
                    locale: {
                        format: 'MMM D, YY hh:mm A',
                        applyLabel: "{{ __('Apply') }}",
                        cancelLabel: "{{ __('Cancel') }}",
                        fromLabel: "{{ __('From') }}",
                        toLabel: "{{ __('To') }}",
                        daysOfWeek: [
                            "{{ __('Sun') }}",
                            "{{ __('Mon') }}",
                            "{{ __('Tue') }}",
                            "{{ __('Wed') }}",
                            "{{ __('Thu') }}",
                            "{{ __('Fri') }}",
                            "{{ __('Sat') }}"
                        ],
                        monthNames: [
                            "{{ __('January') }}",
                            "{{ __('February') }}",
                            "{{ __('March') }}",
                            "{{ __('April') }}",
                            "{{ __('May') }}",
                            "{{ __('June') }}",
                            "{{ __('July') }}",
                            "{{ __('August') }}",
                            "{{ __('September') }}",
                            "{{ __('October') }}",
                            "{{ __('November') }}",
                            "{{ __('December') }}"
                        ],
                    }
                }, cb);
            });
        });
    </script>
@endpush
