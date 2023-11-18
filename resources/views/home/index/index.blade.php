@extends('home.homelayout.app')

@section('script')
    @if($UserRegistered==true)
        <script>
            $(document).ready(function () {
                let UserRegistered = {{ $UserRegistered }};
                if (UserRegistered) {
                    $('#UserRegisteredModal').modal('show');
                }
            });
        </script>
    @endif
    <script>
        @if(\Carbon\Carbon::now() > \Carbon\Carbon::now()->format('Y-m-d 09:00'))
        var config = {
            endDate: '{{ \Carbon\Carbon::now()->format('Y-m-d') }} 17:00',
            timeZone: 'UTC',
            hours: $('#hours'),
            minutes: $('#minutes'),
            seconds: $('#seconds'),
            newSubMessage: 'and should be back online in a few minutes...'
        };
        @else
        var config = {
            endDate: '2020-05-05 17:00',
            timeZone: 'UTC',
            hours: $('#hours'),
            minutes: $('#minutes'),
            seconds: $('#seconds'),
            newSubMessage: 'and should be back online in a few minutes...'
        };
        @endif

    </script>
@endsection

@section('content')

        <div class="alert alert-warning text-center mb-0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet asperiores assumenda, dolor dolores dolorum
            ducimus eius molestiae nam non optio perferendis quo sint unde, veritatis voluptatibus! Ad beatae incidunt
            totam!
        </div>

        <div class="landing-feature">
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        <h3>
                            <span>Market: </span>
                            @if(count($markets)>0)
                                <span class="text-success">Open</span>
                            @else
                                <span class="text-danger">Close</span>
                            @endif
                        </h3>

                        <span style="font-weight: bolder">Total Trade Value:$ 210.650.800</span>
                    </div>
                </div>
                <div style="justify-content: center;display: flex" class="col-md-4 d-flex">
                    <div class="clock">
                        <div class="column">
                            <div class="timer" id="hours"></div>
                            <div class="text hour">Hour</div>
                        </div>
                        <div style="font-family:none !important" class="timer">:</div>
                        <div class="column">
                            <div class="timer" id="minutes"></div>
                            <div class="text">MIN</div>
                        </div>
                        <div style="font-family: normal !important" class="timer">:</div>
                        <div class="column">
                            <div class="timer" id="seconds"></div>
                            <div class="text">SEC</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <h3>{{ Carbon\Carbon::now()->format('l') }}</h3>
                        <span>{{ Carbon\Carbon::now()->format('d M Y g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @include('home.partials.market')


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">More Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">

                        <tr>
                            <th scope="col">Specification</th>
                            <th scope="col">Available</th>
                            <th scope="col">Inspection</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Analysis</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">MSDS</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Min – Max Quantity</th>
                            <th scope="col">10.000-40.000 MT</th>
                            <th scope="col">Partial Shipment</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Loading Port</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">Loading Port</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Delivery Date</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">Demurrage/Dispatch</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Target market</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">Supplier</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Price Type</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">Payment Term</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">Insurance</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                            <th scope="col">Documents</th>
                            <th scope="col">
                                <button class="btn btn-sm btn-danger">Log in/Register</button>
                            </th>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <div class="landing-feature">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Here are a few reasons why <br> you should choose Crypo</h2>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/stroge.svg') }}" alt="">
                        <h3>Secure storage</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/backup.svg') }}" alt="">
                        <h3>Protected by insurance</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/managment.svg') }}" alt="">
                        <h3>Industry best practices</h3>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Modi quaerat, quidem ut, fugiat
                            blanditiis
                            facere</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-number">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2>$657B</h2>
                    <p>Quarterly volume traded</p>
                </div>
                <div class="col-md-4">
                    <h2>100+</h2>
                    <p>Countries supported
                    </p>
                </div>
                <div class="col-md-4">
                    <h2>56+M</h2>
                    <p>Verified users
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-feature landing-start">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Get started in a few steps</h2>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/user.svg') }}" alt="">
                        <span>1</span>
                        <h3>Create an account </h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/bank.svg') }}" alt="">
                        <span>
              2
            </span>
                        <h3>Link your bank account </h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="landing-feature-item">
                        <img src="{{ asset('home/img/landing/trade.svg') }}" alt="">
                        <span>3</span>
                        <h3>Start buying & selling</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="landing-sub">
        <div class="container">
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <div class="landing-sub-content">
                        <h2>Become part of a global community of people who have found their path to the crypto world
                            with Crypo
                        </h2>
                        <a href='signup-dark.html'>Get Started</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

    @if($UserRegistered)
        <!-- Modal -->
        <div class="modal fade" id="UserRegisteredModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $UserRegistered_message->title }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {!! $UserRegistered_message->text !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('home.partials.footer')

@endsection
