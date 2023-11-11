@can('edit-role')
    <a class="btn btn-icon btn-info btn-sm" href="{{ route('roles.show', $role->id) }}" id="edit-role"
        data-action="roles/{{ $role->id }}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
        data-bs-original-title="{{ __('Permissions') }}"><i class="ti ti-key"></i></a>
@endcan
@can('edit-role')
    <a class="btn btn-primary btn-sm edit_role" href="javascript:void(0);" id="edit-role"
        data-action="roles/{{ $role->id }}/edit" data-bs-toggle="tooltip" data-bs-placement="bottom" title=""
        data-bs-original-title="{{ __('Permissions') }}"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-role')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['roles.destroy', $role->id],
        'id' => 'delete-form-' . $role->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $role->id }}"><i
            class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan
