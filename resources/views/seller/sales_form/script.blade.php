<script src="{{ asset('admin/js/bootstrap-select.min.js') }}"></script>
<!-- MDB -->
<script>
    $(document).ready(function () {
        $('#modal_form_id').val(' ');
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
        check_discharging_part()
        check_destination();
        check_safety_file();
        check_reach_certificate_file();
        check_documents();
        show_errors();
        @if(session()->exists('need_submit'))
        show_submit_modal();
        @endif
        @if(session()->exists('form_id_exists'))
        show_modal_form_exists();
        @endif
        let first_error =@json($errors->toArray());
        let i = 0;
        $.each(first_error, function (key, val) {
            if (i == 0) {
                window.location.href = "#" + key;
            }
            i++;
        })
    });

    function maybe_first_in_object(ob) {
        for (var props in ob) {
            return prop;
        }
    }

    function show_submit_modal() {
        let Sales_offer_form_html = $('#sales_offer_form_inputs').html();
        $('#modal_body').html(Sales_offer_form_html);
        $('#modal_body').find('input').prop('disabled', true);
        $('#modal_body').find('textarea').prop('disabled', true);
        $('#modal_body').find('select').prop('disabled', true);
        $('#modal_body').find('button').prop('disabled', true);
        let id = {{ $item }};
        $('#modal_form_id').val(id);
        let NeedToSubmitModal = $('#NeedToSubmitModal');
        NeedToSubmitModal.modal('show');
    }

    function Final_Submit() {
        let modal_form_id = $('#modal_form_id').val();
        let url = "{{ route('admin.Final_Submit') }}";
        $.ajax({
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                id: modal_form_id,
            },
            dataType: 'json',
            method: 'POST',
            beforeSend: function () {

            },
            success: function (msg) {
                if (msg[0] === 1) {
                    window.location.href = "{{ route('admin.sales_form.index',['status'=>1]) }}"
                }
            }
        })
    }

    function show_modal_form_exists() {
        let show_modal_form_exists = $('#show_modal_form_exists');
        show_modal_form_exists.modal('show');
        let previous_form = {{ session()->exists('form_id_exists')?session()->get('form_id_exists'):0 }};
        $('#previous_form').val(previous_form);
    }

    function show_errors() {
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
            $(error_message).insertAfter($('#payment_term_description'));
        }

        let cost_per_unit = "{{ $errors->has('cost_per_unit') }}";
        if (cost_per_unit) {
            let cost_per_unit = "{{ $errors->first('cost_per_unit') }}";
            let error_message = `<p class="input-error-validate">${cost_per_unit}</p>`;
            $(error_message).insertAfter($('#cost_per_unit'));
        }
        let loading_type = "{{ $errors->has('loading_type') }}";
        if (loading_type) {
            $('#loading_common_section').addClass('d-none');
        }
        let discharging_type = "{{ $errors->has('discharging_type') }}";
        if (discharging_type) {
            $('#discharging_common_section').addClass('d-none');
        }
    }

    function check_unit() {
        let old_value = "{{ old('unit') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['unit'])?$form['unit']:'' }}";

            }
        }
        let has_other = value === 'other' ? 1 : 0;
        if (has_other) {
            let has_old = "{{ old('unit_other') }}";

            if (has_old !== '') {
                other_value = "{{ old('unit_other') }}";
            } else {
                other_value = "{{ isset($form['unit_other'])?$form['unit_other']:'' }}"
            }
            hasOther($('#unit'));
            $('#unit_other').val(other_value);
        }
        //check errors
        let unit_other = "{{ $errors->has('unit_other') }}";
        if (unit_other) {
            let unit_other_error = "{{ $errors->first('unit_other') }}";
            let error_message = `<p class="input-error-validate">${unit_other_error}</p>`;
            $(error_message).insertAfter($('#unit_other'));
        }
    }

    function check_currency() {
        let old_value = "{{ old('currency') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['currency'])?$form['currency']:'' }}";

            }
        }
        let has_currency_other = value === 'other' ? 1 : 0;
        if (has_currency_other) {
            let has_old = "{{ old('currency_other') }}";
            if (has_old !== '') {
                other_value = "{{ old('currency_other') }}";
            } else {
                other_value = "{{ isset($form['currency_other'])?$form['currency_other']:'' }}"
            }
            hasOther($('#currency'));
            $('#currency_other').val(other_value);
        }
        //check errors
        let currency_other = "{{ $errors->has('currency_other') }}";
        if (currency_other) {
            let currency_other_error = "{{ $errors->first('currency_other') }}";
            let error_message = `<p class="input-error-validate">${currency_other_error}</p>`;
            $(error_message).insertAfter($('#currency_other'));
        }
    }


    function check_quality_inspection_report_file() {
        let old_value = "{{ old('quality_inspection_report') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['quality_inspection_report'])?$form['quality_inspection_report']:'' }}";
                other_value = "{{ isset($form['quality_inspection_report_file'])?$form['quality_inspection_report_file']:'' }}";
                src = "{{ imageExist(env('SALE_OFFER_FORM'),isset($form['quality_inspection_report_file'])?$form['quality_inspection_report_file']:'') }}"
            }
        }
        let quality_inspection_report = value === 'Yes' ? true : false;
        if (quality_inspection_report) {
            if (other_value == '' || other_value == null) {
                src = null;
            }
            addAttachmentFile($('#quality_inspection_report'), 0, other_value, src);
        }
        let quality_inspection_report_file_error = "{{ $errors->has('quality_inspection_report_file') }}";
        if (quality_inspection_report_file_error) {
            let quality_inspection_report_file = "{{ $errors->first('quality_inspection_report_file') }}";
            let error_message = `<p class="input-error-validate">${quality_inspection_report_file}</p>`;
            $(error_message).insertAfter($('#quality_inspection_report_file'));
        }
    }

    function check_partial_shipment() {
        let old_value = "{{ old('partial_shipment') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['partial_shipment'])?$form['partial_shipment']:'' }}";
                other_value = "{{ isset($form['partial_shipment_number'])?$form['partial_shipment_number']:'' }}";
            }
        }
        let partial_shipment = value === 'Yes' ? 1 : 0;
        if (partial_shipment === 1) {
            addShipmentNumber($('#partial_shipment'));
            $('#partial_shipment_number').val(other_value);
        }
        let partial_shipment_number_error = "{{ $errors->has('partial_shipment_number') }}";
        if (partial_shipment_number_error) {
            let partial_shipment_number = "{{ $errors->first('partial_shipment_number') }}";
            let error_message = `<p class="input-error-validate">${partial_shipment_number}</p>`;
            $(error_message).insertAfter($('#partial_shipment_number'));
        }
    }

    function check_incoterms() {
        let old_value = "{{ old('incoterms') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['incoterms'])?$form['incoterms']:'' }}";

            }
        }
        let has_incoterms_other = value === 'other' ? 1 : 0;
        if (has_incoterms_other) {
            let has_old = "{{ old('currency_other') }}";
            if (has_old !== '') {
                other_value = "{{ old('incoterms_other') }}";
            } else {
                other_value = "{{ isset($form['incoterms_other'])?$form['incoterms_other']:'' }}"
            }
            hasOther($('#incoterms'));
            $('#incoterms_other').val(other_value);
        }
        let incoterms_other_error = "{{ $errors->has('incoterms_other') }}";
        if (incoterms_other_error) {
            let incoterms_other = "{{ $errors->first('incoterms_other') }}";
            let error_message = `<p class="input-error-validate">${incoterms_other}</p>`;
            $(error_message).insertAfter($('#incoterms_other'));
        }
    }

    function check_possible_buyers() {
        let old_value = "{{ old('possible_buyers') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['possible_buyers'])?$form['possible_buyers']:'' }}";

            }
        }
        let has_other = value === 'Yes' ? 1 : 0;
        if (has_other) {
            let has_old = "{{ old('cost_per_unit') }}";
            if (has_old !== '') {
                other_value = "{{ old('cost_per_unit') }}";
            } else {
                other_value = "{{ isset($form['cost_per_unit'])?$form['cost_per_unit']:'' }}"
            }
            hasOther($('#possible_buyers'), 1);
            $('#cost_per_unit').val(other_value);
        }
    }

    function check_packing() {
        let old_value = "{{ old('packing') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['packing'])?$form['packing']:'' }}";
            }
        }
        let has_other = value === 'other' ? 1 : 0;
        if (has_other) {
            let has_old = "{{ old('packing_other') }}";
            if (has_old !== '') {
                other_value = "{{ old('packing_other') }}";
            } else {
                other_value = "{{ isset($form['packing_other'])?$form['packing_other']:'' }}"
            }
            hasOther($('#packing'));
            $('#packing_other').val(other_value);
        }
        let packing_other = "{{ $errors->has('packing_other') }}";
        if (packing_other) {
            let packing_other_error = "{{ $errors->first('packing_other') }}";
            let error_message = `<p class="input-error-validate">${packing_other_error}</p>`;
            $(error_message).insertAfter($('#packing_other'));
        }
    }


    function check_price_type() {
        let old_value = "{{ old('price_type') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['price_type'])?$form['price_type']:'' }}";

            }
        }
        if (value == 'Fix') {
            PriceType($('#price_type'));
            old_value = "{{ old('price') }}";
            if (old_value !== '') {
                other_value = old_value;
            } else {
                if (sale_form_exist === 1) {
                    other_value = "{{ isset($form['price'])?$form['price']:'' }}";
                }
            }
        }
        if (value == 'Formulla') {
            PriceType($('#price_type'));
            old_value = "{{ old('formulla') }}";
            if (old_value !== '') {
                other_value = old_value;
            } else {
                if (sale_form_exist === 1) {
                    other_value = "{{ isset($form['formulla'])?$form['formulla']:'' }}";
                }
            }
        }
        $('#price_type_select').val(other_value);

    }


    function check_safety_file() {
        let old_value = "{{ old('safety_product') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['safety_product'])?$form['safety_product']:'' }}";
                other_value = "{{ isset($form['safety_product_file'])?$form['safety_product_file']:'' }}";
                src = "{{ imageExist(env('SALE_OFFER_FORM'),isset($form['safety_product_file'])?$form['safety_product_file']:'') }}"
            }
        }
        let safety_product = value === 'Yes' ? true : false;
        if (safety_product) {
            if (other_value === '' || other_value == null) {
                src = null;
            }
            addAttachmentFile($('input[name="safety_product"]'), 0, other_value, src, 0);
        }
        //errors
        let safety_product_file = "{{ $errors->has('safety_product_file') }}";
        if (safety_product_file) {
            let safety_product_file = "{{ $errors->first('safety_product_file') }}";
            let error_message = `<p class="input-error-validate">${safety_product_file}</p>`;
            $(error_message).insertAfter($('#safety_product_file'));
        }
    }

    function check_reach_certificate_file() {
        let old_value = "{{ old('reach_certificate') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['reach_certificate'])?$form['reach_certificate']:'' }}";
                other_value = "{{ isset($form['reach_certificate_file'])?$form['reach_certificate_file']:'' }}";
                src = "{{ imageExist(env('SALE_OFFER_FORM'),isset($form['reach_certificate_file'])?$form['reach_certificate_file']:'') }}"
            }
        }
        let reach_certificate = value === 'Yes' ? true : false;
        if (reach_certificate) {
            if (other_value === '' || other_value == null) {
                src = null;
            }
            addAttachmentFile($('input[name="reach_certificate"]'), 0, other_value, src, 0);
        }
        //errors
        let reach_certificate_file = "{{ $errors->has('reach_certificate_file') }}";
        if (reach_certificate_file) {
            let reach_certificate_file = "{{ $errors->first('reach_certificate_file') }}";
            let error_message = `<p class="input-error-validate">${reach_certificate_file}</p>`;
            $(error_message).insertAfter($('#reach_certificate_file'));
        }
    }


    function check_documents() {
        let old_value = "{{ old('documents_options') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['documents_options'])?$form['documents_options']:'' }}";
            }
        }
        let documents_options = value;
        documents_options = documents_options.split(",");
        let documents_options_length = documents_options.length;
        $('#documents_options').val(documents_options);
        $('#documents_count').val(documents_options_length);
        $.each(documents_options, function (key, value) {
            $("#documents-box input[value='" + value + "']").prop('checked', true);
        })
    }

    function check_quality_packing_file() {
        let old_value = "{{ old('picture_packing') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let src = null;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['picture_packing'])?$form['picture_packing']:'' }}";
                other_value = "{{ isset($form['picture_packing_file'])?$form['picture_packing_file']:'' }}";
                src = "{{ imageExist(env('SALE_OFFER_FORM'),isset($form['picture_packing_file'])?$form['picture_packing_file']:'') }}"
            }
        }
        let has_file = value === 'Yes' ? true : false;


        if (has_file) {
            if (other_value === '' || other_value == null) {
                src = null;
            }
            addAttachmentFile($('#picture_packing'), 0, other_value, src);
        }
        let picture_packing_file = "{{ $errors->has('picture_packing_file') }}";
        if (picture_packing_file) {
            let picture_packing_file = "{{ $errors->first('picture_packing_file') }}";
            let error_message = `<p class="input-error-validate">${picture_packing_file}</p>`;

            $(error_message).insertAfter($('#picture_packing_file'));
        }
    }

    function check_payment_term() {
        let old_value = "{{ old('payment_term') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
            other_value = "{{ old('payment_term_description') }}";
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['payment_term'])?$form['payment_term']:'' }}";
                other_value = "{{ isset($form['payment_term_description'])?$form['payment_term_description']:'' }}";
            }
        }
        let has_payment_term = value;
        if (has_payment_term.length !== 0) {
            PaymentTerm($('#payment_term'));
            $('#payment_term_description').val(other_value);
        }
    }

    function hasOther(tag, is_yes = 0) {
        let name = $(tag).attr('name');
        let value = $(tag).val();
        if (is_yes === 0) {
            if (value === 'other') {
                let element = createOtherElement(name);
                $(element).insertAfter($(tag).parent().parent());
            } else {
                removeOtherElement(name);
            }
        } else {
            let field_name = 'cost_per_unit';
            if (value === 'Yes') {
                let element = '<div class="col-12 col-md-6 mb-3"><label for="' + field_name + `" class="mb-2">How Much Will Be Cost Per Unit<span class="text-danger">*</span></label>` +
                    '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                    '</div>';
                $(element).insertAfter($(tag).parent().parent().parent());
            } else {
                $('#' + field_name).parent().remove();
            }
        }
    }

    function DestinationOption(tag) {


        let name = $(tag).attr('name');
        let value = $(tag).val();
        let first_part = value.split(' ');
        let label = first_part[0];
        let field_name = 'exclude_market';
        $('#' + field_name).parent().remove();

        if (value !== 'open') {
            let element = '<div class="col-12 col-md-4 mb-3"><label for="' + field_name + `" class="mb-2">${label} Market<span class="text-danger ml-2">*</span></label>` +
                '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
                '</div>';
            $(element).insertAfter($(tag).parent().parent());
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
        $(element).insertAfter($(tag).parent().parent());
    }

    function PaymentTerm(tag) {
        let name = $(tag).attr('name');
        let value = $(tag).val()
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

    function addAttachmentFile(tag, is_select_option = 0, other_value = null, src = null, is_necessary = 1) {
        let name = $(tag).attr('name');
        let value = $(tag).val();
        if (value === 'Yes') {
            let element = createAttachmentElement(name, src, is_necessary);
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
        return '<div class="col-12 col-md-6 mb-3"><label for="' + field_name + `" class="mb-2">Write Your ${name} <span class="text-danger">*</span></label>` +
            '<input required id="' + field_name + '" type="text" name="' + field_name + '" class="form-control" ' +
            '</div>';
    }

    function createAttachmentElement(name, src = null, is_necessary) {
        let field_name = name + '_file';
        let href = '';
        let star = '';
        if (is_necessary == 1) {
            star = '<span class="text-danger">*</span>';
        }

        if (src != null) {
            href = `<a target="_blank" href="${src}">` +
                ' <i class="fa fa-paperclip ml-3 text-info"></i></a>';
            star = '';
        }
        return `<div class="col-12 col-md-6 mb-3">
                    <label class="mb-2">Attach ${href}${star}</label>
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

    function submitForm(is_save = 0) {
        $('#is_save').val(is_save);
        $('#sales_form').submit();
    }

    function CancelForm(form_id) {
        $('#sales_form')[0].reset();
        if (form_id !== 0) {
            $.ajax({
                url: "{{ route('admin.sales_form.remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: form_id,
                },
                method: "POST",
                dataType: "json",
                success: function (msg) {
                    window.location.href = "{{ route('admin.dashboard') }}";
                }
            })
        } else {
            window.location.href = "{{ route('admin.dashboard') }}";
        }

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
        if (value === 'Flexi Tank') {
            value = 'Flexi_Tank';
        }

        $('#loading_options_sections').removeClass('d-none');
        $('#loading_common_section').removeClass('d-none');
        $('.loading_part').addClass('d-none');
        $('.loading_part').find('input').prop('disabled', true);
        $('.loading_part').find('textarea').prop('disabled', true);
        $('.loading_part').find('select').prop('disabled', true);
        $('#loading_options_' + value).removeClass('d-none');
        $('#loading_options_' + value).find('input').prop('disabled', false);
        $('#loading_options_' + value).find('textarea').prop('disabled', false)
        $('#loading_options_' + value).find('select').prop('disabled', false);
    }

    function RemoveLoadingElement() {
        $('#loading_options').remove();
    }

    function check_loading_part() {
        let old_value = "{{ old('has_loading') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let pre_value;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['has_loading'])?$form['has_loading']:'' }}";
            }
        }
        let has_loading = value == 1 ? 1 : 0;
        if (has_loading) {
            pre_value = "{{ old('loading_type') }}";
            if (old_value !== '') {
                other_value = pre_value;
            } else {
                if (sale_form_exist === 1) {
                    other_value = "{{ isset($form['loading_type'])?$form['loading_type']:'' }}";
                }
            }
            has_loading_change($('#has_loading'));
            let input = $('#loading_options input[value="' + other_value + '"]');
            loadingOption(input);
        }
    }

    function check_discharging_part() {
        let old_value = "{{ old('has_discharging') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        let pre_value;
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['has_discharging'])?$form['has_discharging']:'' }}";
            }
        }
        let has_discharging = value == 1 ? 1 : 0;
        if (has_discharging) {
            pre_value = "{{ old('discharging_type') }}";
            if (old_value !== '') {
                other_value = pre_value;
            } else {
                if (sale_form_exist === 1) {
                    other_value = "{{ isset($form['discharging_type'])?$form['discharging_type']:'' }}";
                }
            }
            has_discharging_change($('#has_discharging'));
            let input = $('#discharging_options input[value="' + other_value + '"]');
            dischargingOption(input);
        }
    }

    function check_destination() {
        let old_value = "{{ old('destination') }}";
        let value;
        let other_value;
        let sale_form_exist = {{ $sale_form_exist }};
        if (old_value !== '') {
            value = old_value;
        } else {
            if (sale_form_exist === 1) {
                value = "{{ isset($form['destination'])?$form['destination']:'' }}";

            }
        }
        let is_open = value === 'open' ? 1 : 0;
        if (!is_open) {
            let has_old = "{{ old('exclude_market') }}";

            if (has_old !== '') {
                other_value = "{{ old('exclude_market') }}";
            } else {
                other_value = "{{ isset($form['exclude_market'])?$form['exclude_market']:'' }}"
            }
            DestinationOption($('#destination'));
            $('#exclude_market').val(other_value);
        }
        //check errors
        let exclude_market = "{{ $errors->has('exclude_market') }}";
        if (exclude_market) {
            let exclude_market_error = "{{ $errors->first('exclude_market') }}";
            let error_message = `<p class="input-error-validate">${exclude_market_error}</p>`;
            $(error_message).insertAfter($('#exclude_market'));
        }
    }

    //discharging part function
    function has_discharging_change(tag) {
        let value = $(tag).is(':checked');
        if (value) {
            $('#discharging_options').removeClass('d-none')
            $('#discharging_options').find('input').prop('disabled', false);
            $('#discharging_options').find('textarea').prop('disabled', false);
            $('#discharging_options').find('select').prop('disabled', false);
        } else {
            $('#discharging_common_section').addClass('d-none');
            $('#discharging_options').addClass('d-none');
            $('#discharging_options').find('input').prop('disabled', true);
            $('#discharging_options').find('textarea').prop('disabled', true);
            $('#discharging_options').find('select').prop('disabled', true);
            $('#discharging_options_sections').removeClass('d-none');
            $('#discharging_options_sections').addClass('d-none');
            $('.discharging_part').addClass('d-none');
            $('.discharging_part').find('input').prop('disabled', true);
            $('.discharging_part').find('textarea').prop('disabled', true);
            $('.discharging_part').find('select').prop('disabled', true);
        }
    }

    function dischargingOption(tag) {
        let value = $(tag).val();
        if (value === 'Flexi Tank') {
            value = 'Flexi_Tank';
        }
        $('#discharging_options_sections').removeClass('d-none');
        $('#discharging_common_section').removeClass('d-none');
        $('.discharging_part').addClass('d-none');
        $('.discharging_part').find('input').prop('disabled', true);
        $('.discharging_part').find('textarea').prop('disabled', true);
        $('.discharging_part').find('select').prop('disabled', true);
        $('#discharging_options_' + value).removeClass('d-none');
        $('#discharging_options_' + value).find('input').prop('disabled', false);
        $('#discharging_options_' + value).find('textarea').prop('disabled', false)
        $('#discharging_options_' + value).find('select').prop('disabled', false);
    }

    function RemoveDischargingElement() {
        $('#discharging_options').remove();
    }


    //end

    function documentOptions() {
        let check_inputs = $("#documents-box input[type='checkbox']:checked");
        let documents = '';
        let pass = 'Yes';
        $.each(check_inputs, function (index, value) {
            let doc_val = $(value).val();
            if (documents == '') {
                documents = doc_val;
            } else {
                documents = documents + ',' + doc_val;
            }
        });
        $('#documents_options').val(documents);
        if (check_inputs.length < 2) {
            pass = 'No';
            $('#documents_options').val('');
        }

        $('#documents_count').val(pass);
    }

    $('select').selectpicker({
        'title': 'Select'
    });
</script>
