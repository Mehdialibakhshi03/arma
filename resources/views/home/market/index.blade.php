@extends('home.homelayout.app')

@section('script')
    <script>
        $(document).ready(function () {
            setInterval(function () {
                refreshMarketTablewithJs({{ $market->id }})
            }, 1000);
        });
        function refreshMarketTablewithJs(val) {
            let statusText = '';
            let market = $('#market-' + val);
            let status = market.attr('data-status');
            let difference = market.attr('data-difference');
            let benchmark1 = market.attr('data-benchmark1');
            let benchmark2 = market.attr('data-benchmark2');
            let benchmark3 = market.attr('data-benchmark3');
            let benchmark4 = market.attr('data-benchmark4');
            let benchmark5 = market.attr('data-benchmark5');
            let benchmark6 = market.attr('data-benchmark6');
            let now = moment();
            benchmark1 = new Date(benchmark1);
            benchmark2 = new Date(benchmark2);
            benchmark3 = new Date(benchmark3);
            benchmark4 = new Date(benchmark4);
            benchmark5 = new Date(benchmark5);
            benchmark6 = new Date(benchmark6);
            if (now < benchmark1) {
                difference = benchmark1 - now;
                status = 1;
                statusText = 'long time to open';
            } else if (benchmark1 < now && now < benchmark2) {
                //ready to open
                difference = benchmark2 - now;
                status = 2;
                statusText = 'ready to open';
            } else if (benchmark2 < now && now < benchmark3) {
                difference = benchmark3 - now;
                status = 3;
                statusText = 'open';
            } else if (benchmark3 < now && now < benchmark4) {
                difference = benchmark4 - now;
                status = 4;
                statusText = 'open(1/3)';
            } else if (benchmark4 < now && now < benchmark5) {
                difference = benchmark5 - now;
                status = 5;
                statusText = 'open(2/3)';
            } else if (benchmark5 < now && now < benchmark6) {
                difference = benchmark6 - now;
                status = 6;
                statusText = 'open(3/3)';
            } else {
                difference = 0;
                status = 7;
                statusText = 'close';
            }
            difference = parseInt(difference / 1000);
            $('#market-difference-' + val).html(difference);
            $('#market-status-' + val).html(statusText);
        }


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


    </script>
@endsection

@section('style')
    <style>
        .error {
            display: none
        }
    </style>
@endsection

@section('content')

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-12 col-md-6 mb-3 d-flex justify-content-center">
                <div style="width: 100%">
                    @for($i=0;$i<34;$i++)
                        <div class="d-flex justify-content-around mb-2">

                            <span class="text-bold text-gray-100">Commodity</span>
                            <span class="text-bold text-dark">Commodity</span>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3 d-flex align-items-center">
                <div style="width: 100%">
                    <div class="row mb-3 justify-content-around align-items-center">
                        <div class="col-12 col-md-6">
                            <h5 class="text-center">Status:

                                <span id="market-status-{{ $market->id }}">
                                {{ $market->status===7 ? 'Close' : '' }}
                            </span>
                            </h5>
                            <div style="display: flex;justify-content: center">
                                <span id="market-difference-{{ $market->id }}">
                                    {{ $market->status===7 ? '0:00' : '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 d-flex align-items-center" style="border: 1px solid black;height: 400px">
                        <div class="col-12 col-md-5">
                            <div
                                style="border: 1px solid black;height: 300px;display: flex;justify-content: center;align-items: center">
                                <div>
                                    <div>
                                        <span>Min Price</span>
                                        <span>350 USD/Mt</span>
                                    </div>
                                    <div>
                                        <span>Quantity</span>
                                        <span>30.000 Mt</span>
                                    </div>
                                    <div>
                                        <span>Min Order</span>
                                        <span>5.000 Mt</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="bids_table" class="col-12 col-md-7" style="height: 300px">

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="price">Price ($)</label>
                            <input disabled type="number" class="form-control disabled_prop" id="price"
                                   placeholder="Price">
                            <p id="price_error" class="text-danger error"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="quantity">Quantity</label>
                            <input disabled type="number" class="form-control disabled_prop" id="quantity"
                                   placeholder="Quantity">
                            <p id="quantity_error" class="text-danger error"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <button disabled onclick="Bid()" class="btn btn-success disabled_prop"
                                    style="width: 150px;">
                                Bid
                            </button>
                        </div>
                    </div>

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
