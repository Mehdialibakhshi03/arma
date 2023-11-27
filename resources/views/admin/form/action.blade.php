@if ($form->json)
    @can('form-fill')
        <a class="btn  btn-sm small btn btn-primary edit_form cust_btn" data-bs-toggle="tooltip"
           data-bs-placement="bottom"
           data-bs-original-title="{{ __('Fill Form') }}" href="{{ route('admin.forms.fill', $form->id) }}"
           id="edit-form"><i class="ti ti-list"></i></a>
    @endcan
@endif

@can('form-duplicate')
    <a href="#" class="btn btn-sm small btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Duplicate Form') }}"
       onclick="document.getElementById('duplicate-form-{{ $form->id }}').submit();"><i
            class="ti ti-squares-diagonal"></i></a>
@endcan

@can('form-edit')
    <a class="btn btn-sm small btn btn-info edit_form cust_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Design Form') }}"
       href="{{ route('admin.forms.design', $form->id) }}"
       id="edit-form"><i class="ti ti-brush"></i></a>
@endcan
@can('form-edit')
    <a class="btn btn-sm small btn btn-primary edit_form cust_btn" href="{{ route('admin.forms.edit', $form->id) }}"
       data-bs-toggle="tooltip" data-bs-placement="bottom"
       data-bs-original-title="{{ __('Edit Form') }}"
       id="edit-form"><i class="ti ti-edit"></i></a>
@endcan
@can('form-delete')
    {!! Form::open([
        'method' => 'post',
        'route' => ['admin.forms.destroy', $form->id],
        'id' => 'delete-form-' . $form->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
       data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"
       id="delete-form-{{ $form->id }}"><i class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan
@can('form-duplicate')
    {!! Form::open(['method' => 'POST', 'route' => ['admin.forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]) !!}
    {!! Form::hidden('form_id', $form->id, []) !!}
    {!! Form::close() !!}
@endcan
