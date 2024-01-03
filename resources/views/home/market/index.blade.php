@extends('home.homelayout.app')

@section('script')
    <script>
        $(document).ready(function () {
            MarketOnline({{ $market->id }});
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
                                    <input disabled id="seller_quantity" type="text" class="form-control"
                                           name="seller_quantity">
                                    <p id="seller_quantity_error" class="error_text">please enter quantity</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="seller_price">Price( {{ $market->SalesForm->currency }} )</label>
                                    <input disabled id="seller_price" type="text" class="form-control"
                                           name="seller_quantity">
                                    <p id="seller_price_error" class="error_text">please enter price</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button disabled id="seller_button"  onclick="Offer({{ $market->id }})"
                                        class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Offer
                                </button>
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
                                    <th class="text-center text-white w-50">

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
                                    <input disabled id="bid_quantity" type="text" class="form-control">
                                    <p id="bid_quantity_error" class="error_text">please enter quantity</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mt-3">
                                    <label for="bid_price">Price( {{ $market->SalesForm->currency }} )</label>
                                    <input disabled id="bid_price" type="text" class="form-control">
                                    <p id="bid_price_error" class="error_text">please enter price</p>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button id="bid_button" disabled onclick="Bid({{ $market->id }})" class="btn btn-secondary pt-1 pb-1 pr-5 pl-5">Bid</button>
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
