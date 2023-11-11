@extends('admin.layouts.main')
@section('title', __('Alert'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Alert') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Alert') }}</li>
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
                                @foreach($alerts as $key=>$item)
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
                                            <a href="{{ route('admin.alert.edit', $item->id) }}" class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"
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
