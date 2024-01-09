<div>
    <hr>
    <strong>Packing</strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Packing';
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
    <select onchange="hasOther(this)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        @foreach($packing as $item)
            <option
                {{ $value==$item->title ? ' selected="selected"' : '' }}
                value="{{ $item->title }}">{{ $item->title }}</option>
        @endforeach
    </select>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="col-12 col-md-6 mb-3">
    @php
        $label='More Details';
        $name='marking_'.$label;
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
    <input {{ $required }} style="margin-top: 28px"
           id="{{ filed_name($name) }}"
              type="text"
              name="{{ filed_name($name) }}"
              class="form-control"
           placeholder="{{ $label }}"
           value="{{ $value }}">
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">

</div>

<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php
        $name='Picture Packing';
        $name=filed_name($name);
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
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! 'Do You have any picture from packing? '.$required_span !!}</label>
        @error(filed_name($name))
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
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php
        $name='Possible Buyers';
        $name=filed_name($name);
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
        <label for="{{ filed_name($name) }}"
               class="mb-2">{!! 'Is Possible The Buyers Order Stencil Marked ?'.$required_span !!}</label>
        @error(filed_name($name))
        <p class="input-error-validate">
            {{ $message }}
        </p>
        @enderror
    </div>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="hasOther(this,1)"
                   {{ $value==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ $name }}"
                   id="{{ $name }}"
                   value="Yes">
            <label class="form-check-label"
                   for="{{ $name }}">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="hasOther(this,1)"
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

