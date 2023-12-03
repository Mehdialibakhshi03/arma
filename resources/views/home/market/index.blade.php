@extends('home.homelayout.app')

@section('script')
    <script>

        var config = {
            endDate: '2024-11-11 17:00',
            timeZone: 'UTC',
            hours: $('#hours'),
            minutes: $('#minutes'),
            seconds: $('#seconds'),
            newSubMessage: 'and should be back online in a few minutes...'
        };

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
                success:function(msg){
                    if (msg){
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
                    $('#market_status').html(msg[1]);
                },

            })
        }
        $(document).ready(function () {
            refreshBidTable();
            refreshMarket();
            setInterval(function (){
                refreshBidTable()
            },3000);

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
                                Open
                            </span>
                            </h5>
                            <div style="display: flex;justify-content: center">
                                <span
                                    style="display: flex;width: 110px;height: 110px;background-color: blue;justify-content: center;align-items: center;border-radius: 100%;color: white">
                                    05:00
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
                            <input type="number" class="form-control" id="price" placeholder="Price">
                            <p id="price_error" class="text-danger error"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                            <p id="quantity_error" class="text-danger error"></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <button onclick="Bid()" class="btn btn-success" style="width: 150px;">
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
