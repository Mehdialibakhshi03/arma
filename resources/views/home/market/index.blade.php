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
    </script>
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
                            <h5 class="text-center">Status:Open</h5>
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
                            <div style="border: 1px solid black;height: 300px;display: flex;justify-content: center;align-items: center">
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
                        <div class="col-12 col-md-7" style="height: 300px">
                            <div style="border: 1px solid black;height: 300px;">
                                <div style="border: 1px solid black;height: 300px;display: flex;justify-content: center;align-items: center">
                                    <div>
                                        <div>
                                            <span>Price</span>
                                            <span>Quantity</span>
                                        </div>
                                        <div>
                                            <span>350</span>
                                            <span>1.000</span>
                                        </div>
                                        <div>
                                            <span>460</span>
                                            <span>30.000</span>
                                        </div>
                                        <div>
                                            <span>670</span>
                                            <span>15.000</span>
                                        </div>
                                        <div>
                                            <span>340</span>
                                            <span>8.000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 d-flex justify-content-center">
                            <button class="btn btn-success" style="width: 150px;">
                                Bid
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center" style="padding: 0">
                            <textarea rows="5" style="width: 100%" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('home.partials.footer')

@endsection
