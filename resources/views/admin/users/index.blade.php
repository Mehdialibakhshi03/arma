@extends('admin.layouts.main')

@section('title')
    {{ $user_status }} Users
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ $user_status }} {{ __('Users') }}</h4>
        </div>
        <ul class="breadcrumb mt-3">
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
            <li class="breadcrumb-item active">{{ $user_status }} {{ __('Users') }}</li>
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
                            <div class="col-12">
                                <h5 class="text-white mb-2">
                                    {{ $type }} users({{ count($users) }})
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>name</th>
                                            <th>email</th>
                                            <th>status</th>
                                            <th>Role</th>
                                            <th>created at</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $key=>$item)
                                            <tr>
                                                <td>
                                                    {{ $users->firstItem()+$key }}
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ $item->email }}
                                                </td>
                                                <td>
                                                    {{ $item->UserStatus->title }}
                                                </td>
                                                <td>
                                                    {{ isset($item->Roles()->first()->name) ? $item->Roles()->first()->name : '-' }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                                                </td>
                                                <td>
                                                    <a style="margin-right: 10px" onclick="removeModal({{ $item->id }},event)"
                                                       class="btn btn-sm btn-danger text-white">
                                                        <i class="icon ion-md-close text-white"></i>
                                                        Delete
                                                    </a>
                                                    <a href="{{ route('admin.user.edit',['type'=>$type,'user'=>$item->id]) }}"
                                                       class="btn btn-sm btn-warning mr-1">
                                                        <i class="icon ion-md-eye text-white"></i>
                                                        Edit
                                                    </a>
                                                    <a href="{{ route('admin.user.wallet',['user'=>$item->id]) }}"
                                                       class="btn btn-sm btn-info mr-1">
                                                        <i class="icon ion-md-eye text-white"></i>
                                                        wallet
                                                    </a>
                                                    {{--                                                            <a href="{{ route('admin.user.mails',['type'=>$type,'user'=>$item->id]) }}"--}}
                                                    {{--                                                               class="btn btn-sm btn-warning mr-1">--}}
                                                    {{--                                                                Mails--}}
                                                    {{--                                                            </a>--}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $users->links() }}
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
