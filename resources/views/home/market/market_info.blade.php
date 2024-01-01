<h5 class="text-center">
    {{ $market->SalesForm->commodity }}
</h5>
<div style="width: 100%">
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Type/Grade</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->type_grade }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">HS Code</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->hs_code }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Cas No</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->cas_no }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Quantity</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->max_quantity }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Min Order</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->min_order }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Partial Shipment</span>
        <span class="text-bold text-light-blue w-50">{{ $market->SalesForm->partial_shipment }}</span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Delivery Term</span>
        <span class="text-bold text-light-blue w-50">
                            -
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Supplier</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->company_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Price Type</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->price_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Offer Price</span>
        <span class="text-bold text-light-blue w-50">
                            -
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Payment term</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->payment_term }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Packing</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->packing }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Marking</span>
        <span class="text-bold text-light-blue w-50">
                            -
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Origin</span>
        <span class="text-bold text-light-blue w-50">
                           -
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Delivery Date</span>
        <span class="text-bold text-light-blue w-50">
                           -
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Loading Port</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->loading_country }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Loading Rate</span>
        <span class="text-bold text-light-blue w-50">
                           {{ $market->SalesForm->bulk_loading_rate }}
                        </span>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Container Type</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->loading_container_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">THC</span>
        <span class="text-bold text-light-blue w-50">
                            ???
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Discharge Port</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->discharging_country }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Discharge Rate</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->bulk_discharging_rate }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Container Type</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->discharging_container_type }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">THC Included</span>
        <span class="text-bold text-light-blue w-50">
                            ???
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Destination</span>
        <span class="text-bold text-light-blue w-50">
                            {{ $market->SalesForm->destination }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Demurrage/Dispatch</span>
        <span class="text-bold text-light-blue w-50">
                            ???
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Inspection</span>
        <span class="text-bold text-light-blue w-50">
                           ???
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Reach Certificate</span>
        <span class="text-bold text-light-blue w-50">
                           {{ $market->SalesForm->reach_certificate }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Insurance</span>
        <span class="text-bold text-light-blue w-50">
                           {{ $market->SalesForm->cargo_insurance }}
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Documents</span>
        <span class="text-bold text-light-blue w-50">
                           ???
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Specification</span>
        <span class="text-bold text-light-blue w-50">
                           <a target="_blank"
                              href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->specification_file)) }}">
                            Download
                        </a>
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">Analysis</span>
        <span class="text-bold text-light-blue w-50">
                        <a target="_blank"
                           href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                           ????
                        </a>
                        </span>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span class="text-bold text-gray-100">MSDS</span>
        <span class="text-bold text-light-blue w-50">
                           <a target="_blank"
                              href="{{ asset(imageExist(env('SALE_OFFER_FORM'),$market->SalesForm->msds)) }}">
                               ???
                           </a>
                        </span>
    </div>
</div>
