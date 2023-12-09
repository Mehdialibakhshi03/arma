<table class="table table-responsive-sm">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Commodity</th>
        <th scope="col">Quantity</th>
        <th scope="col">Packing</th>
        <th scope="col">Delivery Term</th>
        <th scope="col">Region</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col">difference</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($markets as $key=>$market)
        <tr
            id="market-{{ $market->id }}"
            data-status="{{ $market->status }}"
            data-difference="{{ $market->difference }}"
            data-benchmark1="{{ $market->benchmark1 }}"
            data-benchmark2="{{ $market->benchmark2 }}"
            data-benchmark3="{{ $market->benchmark3 }}"
            data-benchmark4="{{ $market->benchmark4 }}"
            data-benchmark5="{{ $market->benchmark5 }}"
            data-benchmark6="{{ $market->benchmark6 }}"
        >
            <td>
                {-
            </td>
            <td>
                -
            </td>
            <td>
                -
            </td>
            <td>
               -
            </td>
            <td>Middle East Gulf</td>
            <td>
                {{ \Carbon\Carbon::parse($market->start)->format('m-d-Y') }}
            </td>
            <td id="market-status-{{ $market->id }}" style="color: {{ $market->Status->color }}">
                {{ \Carbon\Carbon::parse($market->start)->format('H:i') }}
            </td>
            <td id="market-difference-{{ $market->id }}">

            </td>
            <td id="slide_more_angle_{{ $market->id }}" onclick="slidemore({{ $market->id }})"
                class="slide_more_angle d-flex justify-content-center align-items-center cursor-pointer">
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
            <td colspan="9">
                <table style="width: 100%">
                    <tr>
                        <td class="text-bold">Commodity</td>
                        <td>Urea</td>
                        <td class="text-bold">Specification</td>
                        <td>Available</td>
                        <td class="text-bold">Inspection</td>
                        <td>
                            @auth
                                <span>Inspection</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Type</td>
                        <td>Granular</td>
                        <td class="text-bold">Analysis</td>
                        <td>
                            @auth
                                <span>Analysis</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">MSDS</td>
                        <td>Available</td>
                    </tr>
                    <tr>
                        <td class="text-bold">Quantity</td>
                        <td>30.000 MT</td>
                        <td class="text-bold">Min – Max Quantity</td>
                        <td>10.000-40.000 MT</td>
                        <td class="text-bold">Partial Shipment</td>
                        <td>
                            @auth
                                <span>Partial Shipment</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Delivery Term</td>
                        <td>FOB</td>
                        <td class="text-bold">Loading Port</td>
                        <td>
                            @auth
                                <span>Loading Port</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Loading Rate</td>
                        <td>
                            @auth
                                <span>Loading Port</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Packing</td>
                        <td>Bulk</td>
                        <td class="text-bold">Delivery Date</td>
                        <td>
                            @auth
                                <span>Loading Port</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Demurrage/Dispatch</td>
                        <td>
                            @auth
                                <span>Demurrage/Dispatch</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Region</td>
                        <td>Black Sea</td>
                        <td class="text-bold">Target market</td>
                        <td>
                            @auth
                                <span>Target market</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Supplier</td>
                        <td>
                            @auth
                                <span>Supplier</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Minimum Price</td>
                        <td>
                            @auth
                                <span>Minimum Price</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Price Type</td>
                        <td>
                            @auth
                                <span>Price Type</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Payment Term</td>
                        <td>
                            @auth
                                <span>Payment Term</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                    <tr>
                        <td class="text-bold">Contract Type</td>
                        <td>
                            @auth
                                <span>Contract Type</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Insurance</td>
                        <td>
                            @auth
                                <span>Insurance</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                        <td class="text-bold">Documents</td>
                        <td>
                            @auth
                                <span>Documents</span>
                            @else
                                <span class="text-danger">Log in/Register</span>
                            @endauth
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

