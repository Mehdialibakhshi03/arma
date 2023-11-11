@can('download-submitted-form')
    {{--    <a href="{{ route('download.form.values.pdf', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
    {{--        data-bs-original-title="{{ __('Download') }}" title="" class="btn btn-success mr-1 btn-sm small"--}}
    {{--        data-toggle="tooltip"><i class="ti ti-file-download mr-0"></i></a>--}}
@endcan

<a href="{{ route('formvalues.show', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
   title="" data-bs-original-title="{{ __('Show') }}" title="{{ __('View Survey') }}"
   class="btn btn-info mr-1 btn-sm small" data-toggle="tooltip"><i class="ti ti-eye mr-0"></i></a>

@role('Admin')
<button type="button" onclick="CopyFormValue({{ $formValue->id }})" class="btn btn-sm small btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
   title="" data-bs-original-title="{{ __('Duplicate Form') }}">
    <i class="ti ti-squares-diagonal"></i>
</button>
<a href="{{ route('formvalues.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
   title="" data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}"
   class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"><i class="ti ti-edit mr-0"></i> </a>
@endrole
@role('Seller')
@if($formValue->status==3)
    <a href="{{ route('formvalues.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
       title="" data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}"
       class="btn btn-primary mr-1 btn-sm small" data-toggle="tooltip"><i class="ti ti-edit mr-0"></i> </a>
@endif
@endrole
@can('delete-submitted-form')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['formvalues.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
       title="" data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $formValue->id }}"><i
            class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan

