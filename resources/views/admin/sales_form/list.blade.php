@extends('admin.layouts.main')

@section('title')
    Sales Form
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12">
                                <h5 class="text-white mb-2">
                                    Sales Form
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Commodity</th>
                                            <th>User</th>
                                            <th>Status</th>
                                            <th>Change Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $key=>$form)
                                            <tr>
                                                <td>
                                                    {{ $items->firstItem()+$key }}
                                                </td>
                                                <td>
                                                    {{ $form->commodity }}
                                                </td>
                                                <td>
                                                    {{ $form->user_id }}
                                                </td>
                                                <td>
                                                    {{ $form->Status->title }}
                                                </td>
                                                <td>
                                                    @include('admin.sales_form.change_status')
                                                </td>
                                                <td>
                                                    <a onclick="removeModal({{ $form->id }},event)"
                                                       class="btn btn-sm btn-danger text-white mr-1">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a href="{{ route('admin.sale_form',['page_type'=>'Edit','item'=>$form->id]) }}" class="btn btn-sm btn-info text-white mr-1">
                                                        <i class="fa fa-pen"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $items->links() }}
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
                url: "{{ route('admin.sales_form.remove') }}",
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
