@extends('home.homelayout.app')

@section('script')
    <script>
        $(document).ready(function () {
            setInterval(function () {
                refreshMarketTablewithJs({{ $market->id }})
            }, 1000);

            setInterval(function () {
                refreshBidTable()
            }, 3000)
            setInterval(function () {
                let getSeconds = new Date().getSeconds();
                if (getSeconds === 0) {
                    refreshMarket();
                }
            }, 1000)
        });

        refreshMarketTablewithJs({{ $market->id }});

        function refreshBidTable() {
            let market = {{ $market->id }};
            $.ajax({
                url: "{{ route('home.refreshBidTable') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    market: market
                },
                dataType: "json",
                method: 'post',
                success: function (msg) {
                    if (msg) {
                        $('#bids_table').html(msg[1]);
                    }
                }
            })
        }

        function Bid() {
            $('.error').hide();
            let price = $('#price').val();
            let quantity = $('#quantity').val();
            let market = {{ $market->id }};
            $.ajax({
                url: "{{  route('home.bid_market') }}",
                data: {
                    price: price,
                    quantity: quantity,
                    market: market,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                method: "post",
                success: function (msg) {
                    if (msg[0] === 'login') {
                        alert(msg[1]);
                    }
                    if (msg[0] === 'bidder') {
                        alert(msg[1]);
                    }
                    if (msg[0] === 'better_Bid') {
                        alert(msg[1]);
                    }
                    if (msg[0] === 1) {
                        refreshBidTable();
                    }
                },
                error: function (msg) {
                    if (msg.responseJSON.errors) {
                        let errors = msg.responseJSON.errors;
                        $.each(errors, function (i, val) {
                            console.log(i);
                            $('#' + i + '_error').text(val);
                            $('#' + i + '_error').show();
                        })
                    }
                }
            })
        }

        function refreshMarket() {
            let market = {{ $market->id }};
            $.ajax({
                url: "{{  route('home.refreshMarket') }}",
                data: {
                    market: market,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                method: "post",
                success: function (msg) {
                    console.log(msg);
                    $('#market_status').html(msg[1]);
                    let market_is_open = msg[4];
                    // countdownTimmer(msg[2], msg[3]);
                    if (market_is_open === 1) {
                        $('.disabled_prop').prop('disabled', false)
                    } else {
                        $('.disabled_prop').prop('disabled', true)
                    }
                },

            })
        }

        function countdownTimmer(timer2, color) {
            var interval = setInterval(function () {
                var timer = timer2.split(':');
                //by parsing integer, I avoid all extra string processing
                var minutes = parseInt(timer[0], 10);
                var seconds = parseInt(timer[1], 10);
                --seconds;
                minutes = (seconds < 0) ? --minutes : minutes;
                if (minutes < 0) clearInterval(interval);
                seconds = (seconds < 0) ? 59 : seconds;
                seconds = (seconds < 10) ? '0' + seconds : seconds;
                //minutes = (minutes < 10) ?  minutes : minutes;
                if (minutes < 0) {
                    $('.countdown').html('0:00');
                } else {
                    $('.countdown').html(minutes + ':' + seconds);
                }

                $('.countdown').css('background', color)
                timer2 = minutes + ':' + seconds;
            }, 1000);
        }

        $(document).ready(function () {
            refreshBidTable();
            refreshMarket();

        });


    </script>
@endsection

@section('style')
    <style>
        .error {
            display: none
        }

        .bid_textarea {
            width: 100%;
            height: 300px;
            border: 1px solid black;
        }

        .bid_deposit {
            width: 100%;
            height: fit-content;
            border: 1px solid black;
            background-color: #31bd31;
        }

        .bid_term_condition {
            width: 100%;
            height: fit-content;
            border: 1px solid black;
            background-color: #162fa2;
        }

        .bid_input {
            width: 100%;
            height: 50px;
            border: 1px solid black;
        }

        .text-light-blue {
            color: #162fa2;
        }
    </style>
@endsection

@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-4">
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
            </div>
            <div class="col-12 col-md-8">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center">
                            Step : <span id="market-status-{{ $market->id }}"></span>
                        </h5>
                        <span id="market-difference-{{ $market->id }}" class="circle_timer">
                            5:00
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="bid_textarea"></div>
                        <div class="mt-3">
                            <label for="quantity">Quantity( {{ $market->SalesForm->unit }} )</label>
                            <input id="quantity" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="bid_textarea">
                            <table class="table">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Quantity( {{ $market->SalesForm->unit }} )</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                </tbody>
                            </table>

                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <label for="price">Price( {{ $market->SalesForm->price }} )</label>
                            <input id="price" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Bid</button>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bid_textarea"></div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bid_deposit p-3">
                            <h4 class="text-center text-white">Bid Deposit: $120.000</h4>
                            <p class="text-justify">
                                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                    Excepturi, quasi, unde. Aperiam fugiat fugit perferendis soluta vel! Fuga,
                                    illum, nesciunt. Ad animi enim maxime nihil nostrum optio possimus soluta vero!</span>
                                <span>Alias asperiores aut blanditiis consequuntur corporis culpa dolores, eaque error
                                    excepturi fugiat id incidunt iusto, odio qui quibusdam quidem quo rem rerum similique
                                    temporibus ullam velit voluptatem! Doloremque, modi sapiente?</span>
                                <span>Accusamus accusantium at aut, blanditiis cum eos odio provident voluptas.
                                    Accusamus atque debitis deleniti et, inventore laboriosam magni maiores,
                                    maxime nostrum quae ratione tempore ut? Amet enim esse explicabo numquam.</span>
                            </p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Online" id="Online"
                                       name="payment_type">
                                <label class="form-check-label" for="Online">
                                    Online
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Wallet" id="Wallet"
                                       name="payment_type">
                                <label class="form-check-label" for="Wallet">
                                    Wallet
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Cash" id="Cash" name="payment_type">
                                <label class="form-check-label" for="Cash">
                                    Cash
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="Account" id="Account"
                                       name="payment_type">
                                <label class="form-check-label" for="Account">
                                    Account
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="1" id="flexCheckDefault" name="term_condition">
                    <label class="form-check-label" for="flexCheckDefault">
                        <strong>
                            I Read and accept Bid Instruction and General terms and conditions
                        </strong>
                    </label>
                </div>
                <div class="bid_term_condition p-3 text-justify text-white mt-3">
                    <p>
                        For sales and purchase of petroleum, petrochemical, mineral and metal products in addition to
                        the terms and conditions agreed in writing elsewhere between the parties in particular the
                        pro-forma invoice (PI), which are considered as binding and effective between the parties, the
                        following terms and conditions apply to the parties’ relationship unless otherwise agreed
                        between the parties in the PI. By signing the PI, the parties are considered to have agreed with
                        this GTC which are incorporated by reference in the parties’ agreement. The GTC and PI, will be
                        collectively referred to as the “contract”.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" id="market-{{ $market->id }}"
           data-status="{{ $market->status }}"
           data-difference="{{ $market->difference }}"
           data-benchmark1="{{ $market->benchmark1 }}"
           data-benchmark2="{{ $market->benchmark2 }}"
           data-benchmark3="{{ $market->benchmark3 }}"
           data-benchmark4="{{ $market->benchmark4 }}"
           data-benchmark5="{{ $market->benchmark5 }}"
           data-benchmark6="{{ $market->benchmark6 }}">

    @include('home.partials.footer')

@endsection
