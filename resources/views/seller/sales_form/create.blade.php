@extends('admin.layouts.main')

@section('content')
    @include('admin.sales_form.modal')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        @if ($sale_form_exist==1)
                                            <div>
                                                <p>No: {{ $form->unique_number }}</p>
                                                <p>Date: {{ $form->created_at->format('Y-M-d') }}</p>
                                                <p>
                                                    Status: {{ $form->is_complete===1?$form->Status->title:'The form is not complete' }}</p>
                                            </div>
                                        @endif
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form id="sales_form" method="POST" action="{{ $route }}"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div id="sales_offer_form_inputs" class="row">
                                                @include('admin.sales_form.company')

                                                @include('admin.sales_form.unit_currency')

                                                @include('admin.sales_form.product')

                                                @include('admin.sales_form.quantity')

                                                @include('admin.sales_form.quality')

                                                @include('admin.sales_form.incoterm')

                                                @include('admin.sales_form.price_type')

                                                @include('admin.sales_form.payment_term')

                                                @include('admin.sales_form.packing')

                                                @include('admin.sales_form.origin')

                                                @include('admin.sales_form.loading')

                                                @include('admin.sales_form.discharging')

                                                @include('admin.sales_form.destination')

                                                @include('admin.sales_form.inspection')

                                                @include('admin.sales_form.insurance')

                                                @include('admin.sales_form.safety')

                                                @include('admin.sales_form.reach_certificate')

                                                @include('admin.sales_form.documents')

                                                @include('admin.sales_form.contact_person')

                                                @include('admin.sales_form.last_section')
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-12 mt-3">
                                                    <button title="Submit" type="button" onclick="submitForm()"
                                                            class="btn btn-sm btn-info">
                                                        Submit
                                                    </button>
                                                    <button title="Your Information Saved But Not Submitted"
                                                            type="button" onclick="submitForm(1)"
                                                            class="btn btn-sm btn-success">
                                                        Save
                                                    </button>
                                                    <button title="Your Information Permanently deleted" type="button"
                                                            onclick="CancelForm({{ isset($form->id)?$form->id:0 }})"
                                                            class="btn btn-sm btn-danger">
                                                        Cancel
                                                    </button>
                                                    {{--                                                    @include('admin.sales_form.change_status')--}}
                                                </div>
                                            </div>
                                            <input id="is_save" name="is_save" type="hidden" value="0">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css"
          integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endpush

@push('script')
    @include('admin.sales_form.script')
@endpush

