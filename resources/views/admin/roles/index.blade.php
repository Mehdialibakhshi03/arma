@extends('admin.layouts.main')

@section('title')
    index roles
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <div class="d-flex flex-column text-center flex-md-row justify-content-md-between mb-4">
                <h5 class="font-weight-bold mb-3 mb-md-0">
                    Roles ({{ $roles->total() }})
                </h5>
                <div>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.roles.create') }}">
                        <i class="fa fa-plus"></i>
                        Create
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <th>
                                    {{ $roles->firstItem() + $key }}
                                </th>
                                <th>
                                    {{ $role->name }}
                                </th>
                                <th>
                                    <a style="margin-right: 10px" onclick="removeModal({{ $role->id }},event)"
                                       class="btn btn-sm btn-danger text-white">
                                        <i class="icon ion-md-close text-white"></i>
                                        Delete
                                    </a>
                                    <a href="{{ route('admin.roles.edit',['role'=>$role->id]) }}"
                                       class="btn btn-sm btn-warning mr-1">
                                        <i class="icon ion-md-eye text-white"></i>
                                        Edit
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $roles->render() }}
            </div>

        </div>

    </div>
    @include('admin.sections.remove_modal')
@endsection
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
                url: "{{ route('admin.role.delete') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                method: "delete",
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
