<div class="col-12">
    <strong>
        Quality
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Specification';
        $is_required=1;
        $required_span='';
        $required='';
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.' '.$required_span !!}</label>
    <input {{ $required }} id="{{ filed_name($name) }}" type="text"
           name="{{ filed_name($name) }}" class="form-control"
           value="{{ $value }}" placeholder="Please Enter The Product Specification Or Attach As A File">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='specification_file';
        $is_required=0;
        $required_span='';
        $required='';
        $value=null;
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }
    @endphp
    <label class="mb-2">Attach
        @if($value!=null)
            <a target="_blank" href="{{ imageExist(env('SALE_OFFER_FORM'),$value) }}">
                <i class="fa fa-paperclip ml-3 text-info"></i>
            </a>
        @endif
    </label>
    <input class="form-control" type="file" name="specification_file">
    @error('specification_file')
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php
        $name='quality_inspection_report';
        $is_required=0;
        $required_span='';
        $required='';
       //common conditional
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        if (old(filed_name($name)) !== null){
            $value=old(filed_name($name));
        }else{
            if ($sale_form_exist==1){
                $value=$form[filed_name($name)];
            }else{
                $value=null;
            }
        }
    @endphp
    <div>
        <label for="quality_inspection_report" class="mb-2">
            quality inspection/analyse?
        </label>
        @error('quality_inspection_report')
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addAttachmentFile(this)"
                   {{ $value==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ $name }}"
                   id="{{ $name }}"
                   value="Yes">
            <label class="form-check-label"
                   for="{{ $name }}">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addAttachmentFile(this)"
                   {{ $value==='No' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ $name }}"
                   id="{{ $name }}"
                   value="No">
            <label class="form-check-label"
                   for="{{ $name }}">No</label>
        </div>
    </div>
</div>
