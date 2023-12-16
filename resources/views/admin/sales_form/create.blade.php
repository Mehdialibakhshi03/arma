@extends('admin.layouts.main')

@section('content')
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
                                        <a href="#" class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form id="sales_form" method="POST" action="{{ $route }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                @include('admin.sales_form.commodity')

                                                @include('admin.sales_form.product')

                                                @include('admin.sales_form.quantity')

                                                @include('admin.sales_form.quality')

                                                @include('admin.sales_form.shipment_and_incoterm')

                                                @include('admin.sales_form.payment_term')

                                                @include('admin.sales_form.marking')

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

                                                <div class="col-md-12 mt-3">
                                                    <button type="button" onclick="submitForm()"
                                                            class="btn btn-success">Create
                                                    </button>
                                                </div>
                                            </div>
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

