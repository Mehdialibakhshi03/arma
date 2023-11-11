@can('edit-permission')
    <a class="btn  btn-info edit_permission" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Edit') }}" id="edit-permission"
        data-action="permission/{{ $permission->id }}/edit"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-permission')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['permission.destroy', $permission->id],
        'id' => 'delete-form-' . $permission->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $permission->id }}"><i
            class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan
