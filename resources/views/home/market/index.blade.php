@extends('home.homelayout.app')

@section('script')
    <script>
        $(document).ready(function () {
            setInterval(function () {
                refreshMarketTablewithJs({{ $market->id }})
            }, 1000);

            // setInterval(function () {
            //     refreshBidTable()
            // }, 3000)
            // setInterval(function () {
            //     let getSeconds = new Date().getSeconds();
            //     if (getSeconds === 0) {
            //         refreshMarket();
            //     }
            // }, 1000)
        });

        refreshMarketTablewithJs({{ $market->id }});


        function Bid() {
            $('.error_text').hide();
            let price = $('#bid_price').val();
            let quantity = $('#bid_quantity').val();
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
                },
                error: function (msg) {
                    if (msg.responseJSON.errors) {
                        let errors = msg.responseJSON.errors;
                        $.each(errors, function (i, val) {
                            console.log(i);
                            $('#bid_' + i + '_error').text(val);
                            $('#bid_' + i + '_error').show();
                        })
                    }
                }
            })
        }

        function Offer() {
            $('.error_text').hide();
            let price = $('#seller_quantity').val();
            let quantity = $('#seller_price').val();
            let market_id = {{ $market->id }};
            $.ajax({
                url: "{{  route('home.seller_change_offer') }}",
                data: {
                    price: price,
                    quantity: quantity,
                    market_id: market_id,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                method: "post",
                success: function (msg) {
                    if (msg) {
                        if(msg[1]=='user_different'){
                            alert('You Dont have permission to Change Bid Offer');
                        }
                    }
                },
                error: function (msg) {
                    console.log(msg.responseJSON.errors);
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
            height: auto;
            border: 1px solid #7e7e7e;
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

        .bg-blue {
            background-color: #162fa2;
        }

    </style>
@endsection

@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-12 col-xl-4 mb-3">
                @include('home.market.market_info')
            </div>
            <div class="col-12 col-md-12 col-xl-8 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h5 class="text-center status-box">
                            Step : <span id="market-status-{{ $market->id }}"></span>
                        </h5>
                        <span id="market-difference-{{ $market->id }}" class="circle_timer">
                            5:00
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        @include('home.market.seller_table')
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="seller_quantity">Quantity( {{ $market->SalesForm->unit }} )</label>
                                    <input id="seller_quantity" type="text" class="form-control">
                                    <p id="seller_quantity_error" class="error_text">please enter quantity</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="seller_price">Price( {{ $market->SalesForm->currency }} )</label>
                                    <input id="seller_price" type="text" class="form-control">
                                    <p id="seller_price_error" class="error_text">please enter price</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button onclick="Offer()" class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Offer</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="bid_textarea">
                            <table class="table">
                                <thead class="bg-success text-center text-white">
                                <tr>
                                    <th class="text-white" colspan="3">Buy Order</th>
                                </tr>
                                </thead>
                                <thead class="bg-secondary">
                                <tr>
                                    <th class="text-center text-white w-50">Quantity( {{ $market->SalesForm->unit }})
                                    </th>
                                    <th class="text-center text-white w-50">Price ( {{ $market->SalesForm->currency }}
                                        )
                                    </th>
                                </tr>
                                </thead>
                                <tbody id="bidder_offer">
                                @include('home.market.bidder_table')
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="bid_quantity">Quantity( {{ $market->SalesForm->unit }} )</label>
                                    <input id="bid_quantity" type="text" class="form-control">
                                    <p id="bid_quantity_error" class="error_text">please enter quantity</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="bid_price">Price( {{ $market->SalesForm->currency }} )</label>
                                    <input id="bid_price" type="text" class="form-control">
                                    <p id="bid_price_error" class="error_text">please enter price</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button onclick="Bid()" class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Bid</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bid_textarea"></div>
                    </div>
                    <div class="col-12 mt-3">
                        @include('home.market.bid_deposit')
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
                @include('home.market.term_condition')
            </div>
        </div>

    </div>
    <input type="hidden" id="previous_status" value="{{ $market->status }}">

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
