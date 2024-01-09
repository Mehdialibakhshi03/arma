<table class="table table-responsive-sm">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Commodity</th>
        <th scope="col">Quantity</th>
        <th scope="col">Packaging</th>
        <th scope="col">Delivery Term</th>
        <th scope="col">Region</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($markets_groups as $markets)

        @foreach($markets->sortby('time') as $key=>$market)
            <input type="hidden" id="previous_status-{{ $market->id }}" value="{{ $market->status }}">
            @php
                $row_color='black';
            @endphp
            @if(\Carbon\Carbon::parse($market->date)<\Carbon\Carbon::tomorrow())
                @php
                    $row_color='blue';
                @endphp

            @endif
            <tr style="color: {{ $row_color }} !important;" id="market-{{ $market->id }}"
                data-status="{{ $market->status }}"
                data-difference="{{ $market->difference }}"
                data-benchmark1="{{ $market->benchmark1 }}"
                data-benchmark2="{{ $market->benchmark2 }}"
                data-benchmark3="{{ $market->benchmark3 }}"
                data-benchmark4="{{ $market->benchmark4 }}"
                data-benchmark5="{{ $market->benchmark5 }}"
                data-benchmark6="{{ $market->benchmark6 }}"
                data-today-last="{{ $market->is_today_last }}"
            >
                <td>
                    {{ $market->SalesForm->commodity }}
                </td>
                <td>
                    {{ $market->SalesForm->max_quantity.'('.$market->SalesForm->unit.')' }}
                </td>
                <td>
                    {{ $market->SalesForm->packing }}
                </td>
                <td>
                    {{ $market->SalesForm->incoterms }}
                </td>
                <td>
                    {{ $market->SalesForm->country }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($market->date_time)->format('Y-m-d') }}
                </td>
                <td id="market-time-{{ $market->id }}">
                    {{ \Carbon\Carbon::parse($market->date_time)->format('H:i') }}
                </td>
                <td id="slide_more_angle_{{ $market->id }}" onclick="slidemore({{ $market->id }})"
                    class="slide_more_angle cursor-pointer">
                    <span>more</span>
                    <i class="fa fa-angle-down ml-2 mt-1"></i>
                </td>
                <td>
                    <a href="{{ route('home.bid',['market'=>$market->id]) }}" class="btn btn-primary bid-bottom btn-sm">
                        Bid
                    </a>
                </td>
            </tr>
            <tr id="more_table_{{ $market->id }}" style="display: none" class="slide_more_table">
                <td colspan="11">
                    <table class="table-striped table_in_table" style="width: 100%">
                        <tr>
                            <td class="text-left">
                                <span class="text-bold" >Specification</span>
                                <span >Available</span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Contract Type</span>
                                <span > {{ $market->SalesForm->price_type }}</span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Offer Price</span>
                                <span >
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <span class="text-bold" >Partial Shipment</span>
                                <span >{{ $market->SalesForm->partial_shipment }}</span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Supplier</span>
                                <span >{{ $market->SalesForm->company_type }}</span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Peyment Term</span>
                                <span >
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <span class="text-bold" >Insurance</span>
                                <span >Available</span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Target Market</span>
                                <span >
                                    @auth
                                        {{ $market->SalesForm->target_market }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>

                            <td class="text-left">
                                <span class="text-bold" >Delivery Date</span>
                                <span >
                                    @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">
                                <span class="text-bold" >Min Order</span>
                                <span >
                                   {{ $market->SalesForm->min_order }}
                                </span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Inspection</span>
                                <span >
                                    @auth
                                        {{ $market->SalesForm->quality_quantity_inspection }}
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                            <td class="text-left">
                                <span class="text-bold" >Documents</span>
                                <span >
                                   @auth
                                        Available
                                    @else
                                        Log in/Register
                                    @endauth
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

