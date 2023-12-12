<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"
        integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- MDB -->
<script>
    $(document).ready(function () {
        check_unit();
        check_currency();
        check_quality_inspection_report_file();
        check_partial_shipment();
        check_incoterms();
        check_price_type();
        check_payment_term();
        check_packing();
        check_quality_packing_file();
        check_possible_buyers();
        check_loading_part();
        show_errors();
    });

    function show_errors() {
        let unit_other = "{{ $errors->has('unit_other') }}";
        if (unit_other) {
            let unit_other_error = "{{ $errors->first('unit_other') }}";
            let error_message = `<p class="input-error-validate">${unit_other_error}</p>`;
            $(error_message).insertAfter($('#unit_other'));
        }
        let currency_other = "{{ $errors->has('currency_other') }}";
        if (currency_other) {
            let currency_other_error = "{{ $errors->first('currency_other') }}";
            let error_message = `<p class="input-error-validate">${currency_other_error}</p>`;
            $(error_message).insertAfter($('#currency_other'));
        }
        let quality_inspection_report_file_error = "{{ $errors->has('quality_inspection_report_file') }}";
        if (quality_inspection_report_file_error) {
            let quality_inspection_report_file = "{{ $errors->first('quality_inspection_report_file') }}";
            let error_message = `<p class="input-error-validate">${quality_inspection_report_file}</p>`;
            $(error_message).insertAfter($('#quality_inspection_report_file'));
        }
        let partial_shipment_number_error = "{{ $errors->has('partial_shipment_number') }}";
        if (partial_shipment_number_error) {
            let partial_shipment_number = "{{ $errors->first('partial_shipment_number') }}";
            let error_message = `<p class="input-error-validate">${partial_shipment_number}</p>`;
            $(error_message).insertAfter($('#partial_shipment_number'));
        }
        let incoterms_other_error = "{{ $errors->has('incoterms_other') }}";
        if (incoterms_other_error) {
            let incoterms_other = "{{ $errors->first('incoterms_other') }}";
            let error_message = `<p class="input-error-validate">${incoterms_other}</p>`;
            $(error_message).insertAfter($('#incoterms_other'));
        }
        let formulla_error = "{{ $errors->has('formulla') }}";
        if (formulla_error) {
            let formulla = "{{ $errors->first('formulla') }}";
            let error_message = `<p class="input-error-validate">${formulla}</p>`;
            $(error_message).insertAfter($('#price_type_select'));
        }
        let price_error = "{{ $errors->has('price') }}";
        if (price_error) {
            let price = "{{ $errors->first('price') }}";
            let error_message = `<p class="input-error-validate">${price}</p>`;
            $(error_message).insertAfter($('#price_type_select'));
        }
        let payment_term_description_error = "{{ $errors->has('payment_term_description') }}";
        if (payment_term_description_error) {
            let price = "{{ $errors->first('payment_term_description') }}";
            let error_message = `<p class="input-error-validate">${price}</p>`;
            $(error_message).insertAfter($('#payment_term_select'));
        }
        let packing_other = "{{ $errors->has('packing_other') }}";
        if (packing_other) {
            let packing_other_error = "{{ $errors->first('packing_other') }}";
            let error_message = `<p class="input-error-validate">${packing_other_error}</p>`;
            $(error_message).insertAfter($('#packing_other'));
        }
        let picture_packing_file = "{{ $errors->has('picture_packing_file') }}";
        if (picture_packing_file) {
            let picture_packing_file = "{{ $errors->first('picture_packing_file') }}";
            let error_message = `<p class="input-error-validate">${picture_packing_file}</p>`;

            $(error_message).insertAfter($('#picture_packing_file'));
        }
        let cost_per_unit = "{{ $errors->has('cost_per_unit') }}";
        if (cost_per_unit) {
            let cost_per_unit = "{{ $errors->first('cost_per_unit') }}";
            let error_message = `<p class="input-error-validate">${cost_per_unit}</p>`;
            $(error_message).insertAfter($('#cost_per_unit'));
        }
    }

    function check_unit() {
        let has_unit_other = {{ old('unit')==='other' ? 1 : 0 }};
        if (has_unit_other) {
            let old_value = "{{ old('unit_other') }}"
            hasOther($('#unit'));
            $('#unit_other').val(old_value);
        }
    }

    function check_possible_buyers() {
        let has_other = {{ old('possible_buyers')==='Yes' ? 1 : 0 }};
        if (has_other) {
            let old_value = "{{ old('cost_per_unit') }}"
            hasOther($('#possible_buyers'), 1);
            $('#cost_per_unit').val(old_value);
        }
    }

    function check_packing() {
        let has_packing_other = {{ old('packing')==='other' ? 1 : 0 }};
        if (has_packing_other) {
            let old_value = "{{ old('packing_other') }}"
            hasOther($('#packing'));
            $('#packing_other').val(old_value);
        }
    }

    function check_currency() {
        let has_currency_other = {{ old('currency')==='other' ? 1 : 0 }};
        if (has_currency_other) {
            let old_value = "{{ old('currency_other') }}"
            hasOther($('#currency'));
            $('#currency_other').val(old_value);
        }
    }

    function check_partial_shipment() {
        let partial_shipment = {{ old('partial_shipment')==='Yes' ? 1 : 0 }};
        if (partial_shipment === 1) {
            let old_value = "{{ old('partial_shipment_number') }}";
            addShipmentNumber($('#partial_shipment'));
            $('#partial_shipment_number').val(old_value);
        }
    }

    function check_incoterms() {
        let has_incoterms_other = {{ old('incoterms')==='other' ? 1 : 0 }};
        if (has_incoterms_other) {
            let old_value = "{{ old('incoterms_other') }}"
            hasOther($('#incoterms'));
            $('#incoterms_other').val(old_value);
        }
    }

    function check_price_type() {
        let price_type = "{{ old('price_type') }}";

        let previous_val = '';
        if (price_type == 'Fix') {
            PriceType($('#price_type'));
            previous_val = "{{ old('price') }}"
            $('#price_type_select').val(previous_val);
        }
        if (price_type == 'Formulla') {
            PriceType($('#price_type'));

            previous_val = "{{ old('formulla') }}"
            $('#price_type_select').val(previous_val);
        }

    }

    function check_quality_inspection_report_file() {
        let quality_inspection_report = "{{ old('quality_inspection_report')==='Yes' ? true : false }}";
        if (quality_inspection_report) {
            addAttachmentFile($('#quality_inspection_report'));
        }
    }

    function check_quality_packing_file() {
        let picture_packing_file = "{{ old('picture_packing')==='Yes' ? true : false }}";
        if (picture_packing_file) {
            addAttachmentFile($('#picture_packing'), 1);
        }
    }

    function check_payment_term() {
        let has_payment_term = "{{ old('payment_term') }}";
        if (has_payment_term.length !== 0) {
            let old_value = "{{ old('payment_term_description') }}"
            PaymentTerm($('#payment_term'));
            $('#payment_term_description').val(old_value);
        }
    }

    function hasOther(tag, is_yes = 0) {
        let name = $(tag).attr('name');
        let value = $(tag).val();
        if (is_yes === 0) {
            if (value === 'other') {
                let element = createOtherElement(name);
                $(element).insertAfter($(tag).parent());
            } else {
                removeOtherElement(name);
            }
        } else {
            let field_name = 'cost_per_unit';
            if (value === 'Yes') {
                let element = '<div class="mt-3 mb-3"><label for="' + field_name + `" class="mb-2">How Much Will Be Cost Per Unit<span class="text-danger">*</span></label>` +
                    '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                    '</div>';
                $(element).insertAfter($(tag).parent());
            } else {
                $('#' + field_name).parent().remove();
            }
        }

    }

    function PriceType(tag) {
        let name = $(tag).attr('name');
        let value = $(tag).val();
        let id = 'price_type_select';
        let field_label = '';
        let field_name = '';
        let field_type = '';
        if (value === 'Formulla') {
            field_label = 'Formulla (Magazine & Index & Discount & Pricing Period)';
            field_name = 'formulla';
            field_type = 'number';
        } else {
            field_label = 'Price';
            field_name = 'price';
            field_type = 'text';
        }
        $('#' + id).parent().remove();
        let element = '<div class="col-12 col-md-6 mb-3"><label for="' + id + `" class="mb-2">${field_label}<span class="text-danger">*</span></label>` +
            '<input required id="' + id + `" type="${field_type}" name="` + field_name + '" class="form-control" ' +
            '</div>';
        $(element).insertAfter($(tag).parent());
    }

    function PaymentTerm(tag) {
        let name = $(tag).attr('name');
        let value = $(tag).val()
        console.log(value);
        let id = 'payment_term_description';
        let field_label = `${value} Type,${value} Draft,Term and Condition`;
        let field_name = 'payment_term_description';
        let field_type = 'text';
        $('#' + id).parent().remove();
        let element = '<div class="col-12 col-md-6 mb-3"><label for="' + id + `" class="mb-2">${field_label}<span class="text-danger">*</span></label>` +
            '<input required id="' + id + `" type="${field_type}" name="` + field_name + '" class="form-control" ' +
            '</div>';
        $(element).insertAfter($(tag).parent().parent());
    }

    function addShipmentNumber(tag) {
        let value = $(tag).val();
        let field_name = 'partial_shipment_number';
        if (value === 'Yes') {
            let element = '<div class="col-12 col-md-6 mb-3"><label for="' + field_name + `" class="mb-2">Shipment Number<span class="text-danger">*</span></label>` +
                '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                '</div>';
            $(element).insertAfter($(tag).parent().parent().parent());
        } else {
            $(('#' + field_name)).parent().remove();
        }
    }

    function addAttachmentFile(tag, is_select_option = 0) {
        let name = $(tag).attr('name');
        let value = $(tag).val();
        console.log(name, value);
        if (value === 'Yes') {
            let element = createAttachmentElement(name);
            if (is_select_option === 0) {
                $(element).insertAfter($(tag).parent().parent().parent());
            } else {
                $(element).insertAfter($(tag).parent().parent());
            }

        } else {
            RemoveAttachmentElement(name);
        }
    }

    function createOtherElement(name) {
        let field_name = name + '_other';
        return '<div class="mt-3 mb-3"><label for="' + field_name + `" class="mb-2">Write Your ${name} <span class="text-danger">*</span></label>` +
            '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
            '</div>';
    }

    function createAttachmentElement(name) {
        let field_name = name + '_file';
        return `<div class="col-12 col-md-6 mb-3">
                    <label class="mb-2">Attach <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="${field_name}" id="${field_name}">
                    </div>`
    }

    function removeOtherElement(name) {
        let id = name + '_other';
        $('#' + id).parent().remove();
    }

    function RemoveAttachmentElement(name) {
        let id = name + '_file';
        $('#' + id).parent().remove();
    }

    function submitForm() {
        $('#sales_form').submit();
    }

    //loading part function
    function has_loading_change(tag) {
        let value = $(tag).is(':checked');
        if (value) {
            $('#loading_options').removeClass('d-none')
            $('#loading_options').find('input').prop('disabled', false);
            $('#loading_options').find('textarea').prop('disabled', false);
            $('#loading_options').find('select').prop('disabled', false);
        } else {
            $('#loading_common_section').addClass('d-none');
            $('#loading_options').addClass('d-none');
            $('#loading_options').find('input').prop('disabled', true);
            $('#loading_options').find('textarea').prop('disabled', true);
            $('#loading_options').find('select').prop('disabled', true);
            $('#loading_options_sections').removeClass('d-none');
            $('#loading_options_sections').addClass('d-none');
            $('.loading_part').addClass('d-none');
            $('.loading_part').find('input').prop('disabled', true);
            $('.loading_part').find('textarea').prop('disabled', true);
            $('.loading_part').find('select').prop('disabled', true);
        }
    }

    function loadingOption(tag) {
        let value = $(tag).val();
        if (value === 'Flexi Tank'){
            value='Flexi_Tank';
        }
        $('#loading_options_sections').removeClass('d-none');
        $('#loading_common_section').removeClass('d-none');
        $('.loading_part').addClass('d-none');
        $('.loading_part').find('input').prop('disabled', true);
        $('.loading_part').find('textarea').prop('disabled', true);
        $('.loading_part').find('select').prop('disabled', true);
        $('#loading_options_'+value).removeClass('d-none');
        $('#loading_options_'+value).find('input').prop('disabled', false);
        $('#loading_options_'+value).find('textarea').prop('disabled', false)
        $('#loading_options_'+value).find('select').prop('disabled', false);
    }

    function RemoveLoadingElement() {
        $('#loading_options').remove();
    }

    function check_loading_part() {
        let has_loading = {{ old('has_loading')==1 ? 1 : 0 }};
        if (has_loading) {
            has_loading_change($('#has_loading'));
            let pre_value="{{ old('loading_type') }}"
            let input=$('#loading_options input[value="'+pre_value+'"]');
            console.log(input);
            loadingOption(input);
        }
    }

    $('select').selectpicker({
        'title': 'Select'
    });
</script>
