<div class="col-12">
    <strong>
        Quality
    </strong>
</div>
<div class="col-12 text-danger" id="specification_error">
    <strong>
        please write your specification or attach the file <span
            class="text-danger">*</span>
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Specification';
        $is_required=0;
        $required_span='';
        $required='';
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ old(filed_name($name)) }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    <label class="mb-2">Attach</label>
    <input class="form-control" type="file" name="specification_file">
    @error('specification_file')
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div
    class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    <div>
        <label for="quality_inspection_report" class="mb-2">Do You have
            the
            quality inspection report? </label>
        @error('quality_inspection_report')
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addAttachmentFile(this)"
                   {{ old('quality_inspection_report')==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="quality_inspection_report"
                   id="quality_inspection_report"
                   value="Yes">
            <label class="form-check-label"
                   for="inlineRadio1">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addAttachmentFile(this)"
                   {{ old('quality_inspection_report')==='No' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="quality_inspection_report"
                   id="quality_inspection_report"
                   value="No">
            <label class="form-check-label"
                   for="inlineRadio2">No</label>
        </div>
    </div>
</div>
