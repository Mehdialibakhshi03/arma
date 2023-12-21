<div class="col-12">
    <hr>
    <strong>
        Reach Certificate
    </strong>
</div>
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php
    $name='reach_certificate';
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
        <label for="safety_product" class="mb-2">Reach Certificate? <span class="text-danger">*</span></label>
    </div>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addAttachmentFile(this,0,null,null,0)"
                   {{ $value==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}"
                   id="{{ filed_name($name).'1' }}"
                   value="Yes">
            <label class="form-check-label"
                   for="{{ filed_name($name).'1' }}">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addAttachmentFile(this,0,null,null,0)"
                   {{ $value==='No' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}"
                   id="{{ filed_name($name).'2' }}"
                   value="No">
            <label class="form-check-label"
                   for="{{ filed_name($name).'2' }}">No</label>
        </div>
    </div>
</div>
