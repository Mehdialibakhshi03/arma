@can('edit-mailtemplate')
    <a href="{{ route('mailtemplate.edit', $mailtemple->id) }}" class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"
        data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Edit') }}"><i
            class="ti ti-edit mr-0"></i> </a>
@endcan
{{-- @can('delete-mailtemplate')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['mailtemplate.destroy', $mailtemple->id],
        'id' => 'delete-form-' . $mailtemple->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm"
         data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Delete') }}"
         id="delete-form-{{ $mailtemple->id }}"><i class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan --}}
