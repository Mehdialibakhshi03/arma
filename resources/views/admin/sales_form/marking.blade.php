<div class="col-12">
    <hr>
    <strong>
        Marking
    </strong>
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
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $label.'(Packing Material,Marking) '.$required_span !!}</label>
    <textarea rows="1"
              {{ $required }} id="{{ filed_name($name) }}"
              type="text"
              name="{{ filed_name($name) }}"
              class="form-control">{{ $value }}</textarea>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12">

</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Picture Packing';
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
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! 'Do You have any picture from packing? '.$required_span !!}</label>
    <select onchange="addAttachmentFile(this,1)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        <option {{ $value=='Yes' ? ' selected="selected"' : '' }} value="Yes">Yes</option>
        <option {{ $value=='No' ? ' selected="selected"' : '' }} value="No">No</option>
    </select>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='Possible Buyers';
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
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! 'Is Possible The Buyers Order Stencil Marked ? '.$required_span !!}</label>
    <select onchange="hasOther(this,1)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        <option {{ $value=='Yes' ? ' selected="selected"' : '' }} value="Yes">Yes</option>
        <option {{ $value=='No' ? ' selected="selected"' : '' }} value="No">No</option>
    </select>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
