@extends('admin.layouts.main')

@section('title')
    edit roles
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-12 col-md-12 mb-4 p-4 bg-white">
            <hr>
            <form action="{{ route('admin.roles.update', ['role' => $role->id]) }}" method="POST">
                @csrf
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" name="name" type="text" value="{{ $role->name }}">
                    </div>

                    <div class="accordion col-md-12 mt-3" id="accordionPermission">
                        <div class="card">
                            <div class="card-header p-1" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-right" type="button" data-toggle="collapse"
                                        data-target="#collapsePermission" aria-expanded="true" aria-controls="collapseOne">
                                       Permissions
                                    </button>
                                </h2>
                            </div>

                            <div id="collapsePermission" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionPermission">
                                <div class="card-body row">
                                    @foreach ($permissions as $permission)
                                        <div class="form-group form-check col-md-3">
                                            <input type="checkbox" class="form-check-input"
                                                id="permission_{{ $permission->id }}" name="{{ $permission->name }}"
                                                value="{{ $permission->name }}"
                                                {{ in_array( $permission->id , $role->permissions->pluck('id')->toArray() ) ? 'checked' : '' }}
                                                >
                                            <label class="form-check-label mr-3"
                                                for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-outline-primary mt-5" type="submit">Edit</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-dark mt-5 mr-3">Back</a>
            </form>
        </div>

    </div>

@endsection
