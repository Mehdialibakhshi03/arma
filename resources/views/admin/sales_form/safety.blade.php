<div class="col-12">
    <hr>
    <strong>
        Safety
    </strong>
</div>
<div class="col-12 col-md-6 mb-3 d-flex justify-content-between align-items-end">
    @php
    $name='safety_product';
 @endphp
    <div>
        <label for="safety_product" class="mb-2">Is Your Product? <span class="text-danger">*</span></label>
    </div>
    <div>
        <div class="form-check form-check-inline mr-3">
            <input onchange="addAttachmentFile(this)"
                   {{ old(filed_name($name))==='Yes' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}"
                   id="{{ filed_name($name).'1' }}"
                   value="Yes">
            <label class="form-check-label"
                   for="{{ filed_name($name).'1' }}">Yes</label>
        </div>
        <div class="form-check form-check-inline">
            <input onchange="addAttachmentFile(this)"
                   {{ old(filed_name($name))==='No' ? 'checked' : '' }} class="form-check-input"
                   type="radio"
                   name="{{ filed_name($name) }}"
                   id="{{ filed_name($name).'2' }}"
                   value="No">
            <label class="form-check-label"
                   for="{{ filed_name($name).'2' }}">No</label>
        </div>
    </div>
</div>
