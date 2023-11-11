{{-- @if ($form->is_active != 1)
    <a class="btn btn-icon btn-danger text-white btn-sm" href="form-status/{{ $form->id }}" id="edit-form"
        data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Deactive') }}"><i
            class="ti ti-ban"></i></a>
@else
    <a class="btn btn-icon btn-success btn-sm" href="form-status/{{ $form->id }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Active') }}"><i
            class="ti ti-check"></i></a>
@endif --}}
{{--@can('edit-form')--}}
{{--    @if ($form->json)--}}
{{--        @php--}}
{{--            $hashids = new Hashids('', 20);--}}
{{--            $id = $hashids->encodeHex($form->id);--}}
{{--        @endphp--}}
{{--        <a class="btn  btn-sm small btn btn-primary embed_form" href="javascript:void(0)"--}}
{{--            onclick="copyToClipboard('#embed-form-{{ $form->id }}')" id="embed-form-{{ $form->id }}"--}}
{{--            data-bs-toggle="tooltip" data-bs-placement="bottom" title=""--}}
{{--            data-bs-original-title="{{ __('Embedded form') }}"--}}
{{--            data-url='<iframe src="{{ route('forms.survey', $id) }}" scrolling="auto" align="bottom" style="height:100vh;" width="100%"></iframe>'><i--}}
{{--                class="ti ti-code"></i></a>--}}

{{--        <a class="btn  btn btn-success btn-sm small copy_form" onclick="copyToClipboard('#copy-form-{{ $form->id }}')"--}}
{{--            href="javascript:void(0)" id="copy-form-{{ $form->id }}" data-bs-toggle="tooltip" data-bs-placement="bottom"--}}
{{--            title="" data-bs-original-title="{{ __('Copy Form URL') }}" data-url="{{ route('forms.survey', $id) }}"><i--}}
{{--                class="ti ti-copy"></i></a>--}}

{{--        <a class="btn  btn-sm small btn btn-info text-white edit_form cust_btn"--}}
{{--            data-share="{{ route('forms.survey.qr', $id) }}" id="share-qr-code" id="edit-form" data-bs-toggle="tooltip"--}}
{{--            data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Show QR Code') }}"><i--}}
{{--                class="ti ti-qrcode"></i></a>--}}
{{--    @endif--}}
{{--@endcan--}}
@can('fill-form')
    @if ($form->json)

        <a class="btn  btn-sm small btn btn-primary edit_form cust_btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="" data-bs-original-title="{{ __('Fill Form') }}" href="{{ route('forms.fill', $form->id) }}"
            id="edit-form"><i class="ti ti-list"></i></a>
    @endif
@endcan

    <a href="#" class="btn btn-sm small btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Duplicate Form') }}"
        onclick="document.getElementById('duplicate-form-{{ $form->id }}').submit();"><i
            class="ti ti-squares-diagonal"></i></a>

@can('edit-form')
    <a class="btn btn-sm small btn btn-info edit_form cust_btn" data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="" data-bs-original-title="{{ __('Design Form') }}" href="{{ route('forms.design', $form->id) }}"
        id="edit-form"><i class="ti ti-brush"></i></a>
@endcan
@can('edit-form')
    <a class="btn btn-sm small btn btn-primary edit_form cust_btn" href="{{ route('forms.edit', $form->id) }}"
        data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Edit Form') }}"
        id="edit-form"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-form')
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['forms.destroy', $form->id],
        'id' => 'delete-form-' . $form->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-sm small btn btn-danger show_confirm" data-bs-toggle="tooltip"
        data-bs-placement="bottom" title="" data-bs-original-title="{{ __('Delete') }}"
        id="delete-form-{{ $form->id }}"><i class="ti ti-trash mr-0"></i></a>
    {!! Form::close() !!}
@endcan
@can('duplicate-form')
    {!! Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]) !!}
    {!! Form::hidden('form_id', $form->id, []) !!}
    {!! Form::close() !!}
@endcan
