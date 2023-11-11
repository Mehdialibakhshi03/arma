@extends('admin.layouts.main')

@section('title')
    {{ $status }} {{ __('Markets') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ $status }} {{ __('Markets') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12">
                                        <h5 class="text-white mb-2">
                                            {{ $status.' Market ' }}({{ count($markets) }})
                                        </h5>
                                    </div>
                                    <div class="col-md-12">
                                        <a class="btn btn-secondary" href="{{ route('admin.market.create',['status'=>$status]) }}">+ create</a>
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>start</th>
                                                    <th>end</th>
                                                    <th>action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($markets as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $markets->firstItem()+$key }}
                                                        </td>
                                                        <td>
                                                            {{ $item->title }}
                                                        </td>
                                                        <td>
                                                            {{ $item->description }}
                                                        </td>
                                                        <td>
                                                            {{ $item->start }}
                                                        </td>
                                                        <td>
                                                            {{ $item->end }}
                                                        </td>
                                                        <td>
                                                            <button onclick="removeModal({{ $item->id }},event)" class="btn btn-sm btn-danger">Remove</button>
                                                            <a href="{{ route('admin.market.edit',['market'=>$item->id,'status'=>$status]) }}" class="btn btn-sm btn-info">Edit</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="text-center">
                                                <div class="d-flex justify-content-center mt-4">
                                                    {{ $markets->links() }}
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
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection
@push('style')
    @include('admin.layouts.includes.datatable_css')
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
                url: "{{ route('admin.market.remove') }}",
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