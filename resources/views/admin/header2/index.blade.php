{{--@extends('admin.layouts')--}}

{{--@section('title')--}}
{{--    Setting - header 1--}}
{{--@endsection--}}
{{--@section('script')--}}
{{--    <script>--}}
{{--        function removeModal(id, e) {--}}
{{--            e.stopPropagation();--}}
{{--            let remove_modal = $('#remove_modal');--}}
{{--            $('#id').val(id);--}}
{{--            remove_modal.modal('show');--}}
{{--        }--}}

{{--        function Remove() {--}}
{{--            let id = $('#id').val();--}}
{{--            $.ajax({--}}
{{--                url: "{{ route('admin.header1.remove') }}",--}}
{{--                data: {--}}
{{--                    _token: "{{ csrf_token() }}",--}}
{{--                    id: id,--}}
{{--                },--}}
{{--                dataType: "json",--}}
{{--                method: "post",--}}
{{--                beforeSend: function () {--}}

{{--                },--}}
{{--                success: function (msg) {--}}
{{--                    if (msg) {--}}
{{--                        $('#remove_modal').modal('hide');--}}
{{--                        if (msg[0] == 1) {--}}
{{--                            window.location.reload();--}}
{{--                        } else {--}}
{{--                            $('#alert').html(msg[1]);--}}
{{--                        }--}}
{{--                    }--}}
{{--                }--}}
{{--            })--}}
{{--        }--}}
{{--    </script>--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <div class="settings mtb15">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12 col-lg-3">--}}
{{--                    @include('admin.sidebar')--}}
{{--                </div>--}}
{{--                <div class="col-md-12 col-lg-9">--}}
{{--                    <div>--}}
{{--                        <div>--}}
{{--                            <div class="card">--}}
{{--                                <div class="card-body">--}}
{{--                                    @include('admin.sections.alert')--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="markets-pair-list">--}}
{{--                                            <div id="alert"></div>--}}
{{--                                            <div>--}}
{{--                                                <a href="{{ route('admin.header1.create') }}"--}}
{{--                                                   class="btn btn-success btn-sm mb-2">--}}
{{--                                                    <i class="icon ion-md-add mr-1"></i>--}}
{{--                                                    New--}}
{{--                                                </a>--}}
{{--                                            </div>--}}
{{--                                            <table class="table table-striped">--}}
{{--                                                <thead>--}}
{{--                                                <tr class="bg-dark">--}}
{{--                                                    <th class="text-white">priority</th>--}}
{{--                                                    <th class="text-white">Title</th>--}}
{{--                                                    <th class="text-white">Number 1(min)</th>--}}
{{--                                                    <th class="text-white">Number 2(max)</th>--}}
{{--                                                    <th class="text-white">Number 3</th>--}}
{{--                                                    <th class="text-white">created at</th>--}}
{{--                                                    <th class="text-white"></th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @foreach($items as $key=>$item)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $item->priority }}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $item->title }}--}}
{{--                                                        </td>--}}
{{--                                                        <td class="{{ $item->number_1>0 ? 'text-success' : ($item->number_1<0 ? 'text-danger' : 'text-muted') }}">--}}
{{--                                                            {{ $item->number_1 }}--}}
{{--                                                        </td>--}}
{{--                                                        <td class="{{ $item->number_2>0 ? 'text-success' : ($item->number_2<0 ? 'text-danger' : 'text-muted') }}">--}}
{{--                                                            {{ $item->number_2 }}--}}
{{--                                                        </td>--}}
{{--                                                        <td class="{{ $item->number_3>0 ? 'text-success' : ($item->number_3<0 ? 'text-danger' : 'text-muted') }}">--}}
{{--                                                            {{ $item->number_3. ' % ' }}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}--}}
{{--                                                        </td>--}}
{{--                                                        <td class="d-flex justify-content-center">--}}
{{--                                                            <a onclick="removeModal({{ $item->id }},event)"--}}
{{--                                                               class="btn btn-sm btn-danger mr-3">--}}
{{--                                                                <i class="icon ion-md-close text-white"></i>--}}
{{--                                                            </a>--}}
{{--                                                            <a href="{{ route('admin.header1.edit',['item'=>$item->id]) }}"--}}
{{--                                                               class="btn btn-sm btn-warning ">--}}
{{--                                                                <i class="icon ion-md-eye text-white"></i>--}}
{{--                                                            </a>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
{{--                                                </tbody>--}}
{{--                                            </table>--}}
{{--                                            <div class="text-center">--}}
{{--                                                <div class="d-flex justify-content-center mt-4">--}}
{{--                                                    {{ $items->links() }}--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--@endsection--}}

@extends('admin.layouts.main')
@section('title', __('Header 2'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Header 2') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Header 2') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4">
                        <div style="padding: 5px 26px;" class="btn-group">
                            <a id="add_header2" class="btn btn-default btn-primary btn-sm no-corner " tabindex="0" aria-controls="users-table"><span><i class="ti ti-plus"></i> Create</span></a>
                        </div>
                        <div class="container-fluid">

                            <table class="table table-striped">
                                <thead>
                                <tr class="bg-dark">
                                    <th>priority</th>
                                    <th>Title</th>
                                    <th>Number 1(min)</th>
                                    <th>Number 2(max)</th>
                                    <th>Number 3</th>
                                    <th>created at</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $key=>$item)
                                    <tr>
                                        <td>
                                            {{ $item->priority }}
                                        </td>
                                        <td>
                                            {{ $item->title }}
                                        </td>
                                        <td class="{{ $item->number_1>0 ? 'text-success' : ($item->number_1<0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $item->number_1 }}
                                        </td>
                                        <td class="{{ $item->number_2>0 ? 'text-success' : ($item->number_2<0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $item->number_2 }}
                                        </td>
                                        <td class="{{ $item->number_3>0 ? 'text-success' : ($item->number_3<0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $item->number_3. ' % ' }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            {!! Form::open([
'method' => 'POST',
'route' => ['admin.header2.remove', $item->id],
'id' => 'delete-form-' . $item->id,
'class' => 'd-inline',
]) !!}
                                            <a href="#" class="btn btn-sm small btn-danger show_confirm" id="delete-form-{{ $item->id }}"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
                                               data-bs-original-title="{{ __('Delete') }}"><i class="ti ti-trash mr-1"></i></a>
                                            {!! Form::close() !!}
                                            <a data-action="/admin-panel/management/setting/header2/edit/{{ $item->id }}" style="margin-left: 10px" href="javascript:void(0);"
                                               class="btn btn-icon btn-primary btn-sm edit-header2">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            $('body').on('click', '#add_header2', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('admin.header2.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create Header') }}');
                        modal.find('.body').html(response.html);
                        modal.modal('show');
                    },
                    error: function(error) {}
                });
            });
            $('body').on('click', '.edit-header2', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal');
                $.get(action, function(response) {

                    modal.find('.modal-title').html('{{ __('Edit Header2') }}');
                    modal.find('.body').html(response.html);

                    modal.modal('show');
                })
            });
        });

    </script>
@endpush
