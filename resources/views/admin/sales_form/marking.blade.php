<div class="col-12">
    <hr>
    <strong>
        Marking
    </strong>
</div>
<div class="col-12 col-md-6 mb-3">
    @php
        $name='More Details';
        $is_required=0;
        $required_span='';
        $required='';
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
        $text_area_name='marking_'.$name;
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! $name.'(Packing Material,Marking) '.$required_span !!}</label>
    <textarea rows="1"
              {{ $required }} id="{{ filed_name($text_area_name) }}"
              type="text"
              name="{{ filed_name($text_area_name) }}"
              class="form-control">{{ old(filed_name($text_area_name)) }}</textarea>
    @error(filed_name($text_area_name))
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
        $is_required=1;
        $required_span='';
        $required='';
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! 'Do You have any picture from packing? '.$required_span !!}</label>
    <select onchange="addAttachmentFile(this,1)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        <option {{ old(filed_name($name))=='Yes' ? ' selected="selected"' : '' }} value="Yes">Yes</option>
        <option {{ old(filed_name($name))=='No' ? ' selected="selected"' : '' }} value="No">No</option>
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
        $is_required=1;
        $required_span='';
        $required='';
        if ($is_required===1){
            $required_span='<span class="text-danger">*</span>';
            $required='required';
        }
    @endphp
    <label for="{{ filed_name($name) }}"
           class="mb-2">{!! 'Is Possible The Buyers Order Stencil Marked ? '.$required_span !!}</label>
    <select onchange="hasOther(this,1)"
            {{ $required }} id="{{ filed_name($name) }}" type="text"
            name="{{ filed_name($name) }}" class="form-control ">
        <option {{ old(filed_name($name))=='Yes' ? ' selected="selected"' : '' }} value="Yes">Yes</option>
        <option {{ old(filed_name($name))=='No' ? ' selected="selected"' : '' }} value="No">No</option>
    </select>
    @error(filed_name($name))
    <p class="input-error-validate">
        {{ $message }}
    </p>
    @enderror
</div>
