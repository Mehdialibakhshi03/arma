{{--@extends('admin.layouts')--}}

{{--@section('title')--}}
{{--Messages - emails--}}
{{--@endsection--}}

{{--@section('style')--}}
{{--    <style>--}}
{{--        .markets-pair-list th, .markets-pair-list td{--}}
{{--            width: auto !important;--}}
{{--        }--}}
{{--    </style>--}}
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
{{--                url: "#",--}}
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
{{--                                    <div class="col-12">--}}
{{--                                        <h5 class="text-white mb-2">--}}
{{--                                            Mail Messages--}}
{{--                                        </h5>--}}
{{--                                    </div>--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="markets-pair-list">--}}
{{--                                            <div id="alert"></div>--}}
{{--                                            <table class="table table-striped">--}}
{{--                                                <thead>--}}
{{--                                                <tr class="bg-dark">--}}
{{--                                                    <th class="text-white">#</th>--}}
{{--                                                    <th class="text-white">title</th>--}}
{{--                                                    <th class="text-white">Description</th>--}}
{{--                                                    <th class="text-white"></th>--}}
{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody>--}}
{{--                                                @foreach($emails as $key=>$item)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $emails->firstItem()+$key }}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $item->title }}--}}
{{--                                                        </td>--}}
{{--                                                        <td>--}}
{{--                                                            {{ $item->description }}--}}
{{--                                                        </td>--}}
{{--                                                        <td class="d-flex justify-content-center">--}}
{{--                                                            <a onclick="removeModal({{ $item->id }},event)"--}}
{{--                                                               class="btn btn-sm btn-danger mr-3">--}}
{{--                                                                <i class="icon ion-md-close text-white"></i>--}}
{{--                                                            </a>--}}
{{--                                                            <a href="{{ route('admin.email.edit',['mail'=>$item->id]) }}"--}}
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
{{--                                                    {{ $emails->links() }}--}}
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
{{--    @include('admin.sections.remove_modal')--}}
{{--@endsection--}}


@extends('admin.layouts.main')
@section('title', __('Email'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Email') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Email') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4">
                        <div class="container-fluid">
                            <table class="table table-striped">
                                                                                <thead>
                                                                                <tr class="bg-dark">
                                                                                    <th>#</th>
                                                                                    <th>title</th>
                                                                                    <th>Description</th>
                                                                                    <th></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                @foreach($emails as $key=>$item)
                                                                                    <tr>
                                                                                        <td>
                                                                                            {{ +$key }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ $item->title }}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{ $item->description }}
                                                                                        </td>
                                                                                        <td class="d-flex justify-content-center">
                                                                                            <a href="{{ route('admin.email.edit', $item->id) }}" class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"
                                                                                               data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Edit') }}"><i
                                                                                                    class="ti ti-edit mr-0"></i> </a>
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
        {{--$(function() {--}}

        {{--    $('body').on('click', '.edit-message', function() {--}}
        {{--        var action = $(this).data('action');--}}
        {{--        var modal = $('#common_modal');--}}
        {{--        $.get(action, function(response) {--}}

        {{--            modal.find('.modal-title').html('{{ __('Edit Message') }}');--}}
        {{--            modal.find('.body').html(response.html);--}}

        {{--            modal.modal('show');--}}
        {{--        })--}}
        {{--    });--}}
        {{--});--}}

    </script>
@endpush
