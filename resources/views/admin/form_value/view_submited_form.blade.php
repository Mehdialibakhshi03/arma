@extends('admin.layouts.main')
@section('title', __('Submitted Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ $title }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ $title }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Form</th>
                                            <th>status</th>
                                            <th>created at</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($form_values as $key=>$item)
                                            <tr>
                                                <td>
                                                    {{ $form_values->firstItem()+$key }}
                                                </td>
                                                <td>
                                                    {{ $item->User->name }}
                                                </td>
                                                <td>
                                                    {{ $item->Form->title }}
                                                </td>
                                                <td>
                                                    {{ $item->Status->title }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                                                </td>
                                                <td>
                                                    {{--<a href="{{ route('admin.download.form.values.pdf', $formValue->id) }}" data-bs-toggle="tooltip"--}}
                                                    {{--   data-bs-placement="bottom"--}}
                                                    {{--   data-bs-original-title="{{ __('Download') }}" title="" class="btn btn-success mr-1 btn-sm small"--}}
                                                    {{--   data-toggle="tooltip"><i class="ti ti-file-download mr-0"></i></a>--}}

                                                    @can('commodity-show')
                                                        <a href="{{ route('admin.formvalues.show', $item->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                           class="btn btn-info mr-1 btn-sm small" data-toggle="tooltip"><i class="ti ti-eye mr-0"></i>
                                                        </a>
                                                    @endcan

                                                    {{--@can('commodity-duplicate')--}}
                                                    {{--    <button type="button" onclick="CopyFormValue({{ $formValue->id }})" class="btn btn-sm small btn btn-warning"--}}
                                                    {{--            data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
                                                    {{--            data-bs-original-title="{{ __('Duplicate Form') }}">--}}
                                                    {{--        <i class="ti ti-squares-diagonal"></i>--}}
                                                    {{--    </button>--}}
                                                    {{--@endcan--}}
                                                    @can('commodity-edit')
                                                        {{--    @if($formValue->status==3)--}}
                                                        <a href="{{ route('admin.formvalues.edit', $item->id) }}" data-bs-toggle="tooltip"
                                                           data-bs-placement="bottom"
                                                           data-bs-original-title="{{ __('Edit') }}"
                                                           class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"><i class="ti ti-edit mr-0"></i> </a>
                                                        {{--    @endif--}}
                                                    @endcan

                                                    @can('commodity-delete')
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['admin.formvalues.destroy', $item->id],
                                                            'id' => 'delete-form-' . $item->id,
                                                            'class' => 'd-inline',
                                                        ]) !!}
                                                        <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                           data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $item->id }}"><i
                                                                class="ti ti-trash mr-0"></i></a>
                                                        {!! Form::close() !!}
                                                    @endcan


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $form_values->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection
@push('style')

@endpush
@push('script')
    <script>
        function removeModal(id, e) {
            e.stopPropagation();
            let remove_modal = $('#remove_modal');
            $('#id').val(id);
            remove_modal.modal('show');
        }

        function Remove() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.user.remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {

                },
                success: function (msg) {
                    if (msg) {
                        $('#remove_modal').modal('hide');
                        if (msg[0] == 1) {
                            window.location.reload();
                        } else {
                            $('#alert').html(msg[1]);
                        }
                    }
                }
            })
        }
    </script>
@endpush
