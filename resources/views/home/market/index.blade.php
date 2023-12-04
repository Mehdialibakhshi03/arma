@extends('home.homelayout.app')

@section('script')
    <script>


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
                    countdownTimmer(msg[2], msg[3]);
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

                                <span id="market_status">
                                {{ $market->status===7 ? 'Close' : '' }}
                            </span>
                            </h5>
                            <div style="display: flex;justify-content: center">
                                <span class="countdown countdownTimerBid {{ $market->status===7 ? 'bg-danger' : '' }}">
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

    @include('home.partials.footer')

@endsection
