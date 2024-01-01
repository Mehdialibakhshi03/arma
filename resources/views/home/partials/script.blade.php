<script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts-core.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts.min.js') }}"></script>
<script src="{{ asset('home/js/custom.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.4/moment-timezone-with-data.js"></script>
<script src="{{ asset('home/js/timer.js') }}"></script>
<script src="{{ asset('home/js/yscountdown.min.js') }}"></script>
<script src="{{ asset('home/js/font-awsome.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    let header1Width = $('#scroll-container').find('div')[0].clientWidth;
    let width = screen.width;
    if (header1Width > width) {
        $('#scroll-container').addClass('scroll-container');
    }
    let header1Width2 = $('#scroll-container2').find('div')[0].clientWidth;
    let width2 = screen.width;
    if (header1Width2 > width2) {
        $('#scroll-container2').addClass('scroll-container');
    }
    var endDate = "{{ \Carbon\Carbon::parse(now())->format('Y/m/d') }} {{  $end_market }}";
    var counterElement = document.querySelector("#counter");
    var Hours = $('#Hours');
    var Minutes = $('#Minutes');
    var Seconds = $('#Seconds');
    var myCountDown = new ysCountDown(endDate, function (remaining, finished) {
        var message = "";
        if (finished) {
            message = "Expired";
            $('#timer').text(message);
        } else {
            if (remaining.seconds < 10) {
                remaining.seconds = '0' + remaining.seconds;
            }
            if (remaining.minutes < 10) {
                remaining.minutes = '0' + remaining.minutes;
            }
            if (remaining.hours < 10) {
                remaining.hours = '0' + remaining.hours;
            }
            Hours.text(remaining.hours);
            Minutes.text(remaining.minutes);
            Seconds.text(remaining.seconds);
        }

    });

    function refreshMarketTablewithJs(id) {
        let canBid = false;
        let goToEnd = 0;
        let change_color = 0;
        let statusText = '';
        let market = $('#market-' + id);
        let previous_status = $('#previous_status').val();
        let status;
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
            statusText = '<span>Waiting To Open</span>';
        } else if (benchmark1 < now && now < benchmark2) {
            //ready to open
            difference = benchmark2 - now;
            status = 2;
            change_color = 1;
            color = '#8a8a00';
            statusText = '<span>Ready to open</span>';
        } else if (benchmark2 < now && now < benchmark3) {
            canBid = true;
            difference = benchmark3 - now;
            status = 3;
            color = '#1f9402';
            change_color = 1;
            statusText = '<span>Open</span>';
        } else if (benchmark3 < now && now < benchmark4) {
            difference = benchmark4 - now;
            status = 4;
            color = '#135e00';
            change_color = 1;
            statusText = '<span>Open(1/3)</span>';
        } else if (benchmark4 < now && now < benchmark5) {
            difference = benchmark5 - now;
            status = 5;
            color = '#104800';
            change_color = 1;
            statusText = '<span>Open(2/3)</span>';
        } else if (benchmark5 < now && now < benchmark6) {
            difference = benchmark6 - now;
            status = 6;
            color = '#0a2a00';
            change_color = 1;
            statusText = '<span>Open(3/3)</span>';
        } else {
            difference = 0;
            status = 7;
            color = '#ff0000';
            change_color = 1;
            statusText = '<span>Close</span>';
        }
        $('#previous_status').val(status);
        difference = parseInt(difference / 1000);
        if (change_color) {
            $('#market-' + id).css('color', color);
            $('.status-box').css('color', color);
            $('.circle_timer').css('background', color);
        }
        if (previous_status != status) {
            change_status_market(id, status);
        }
        // if (canBid){
        //     $('#quantity_bid_box').prop('disabled', false);
        //     $('#price_bid_box').prop('disabled', false);
        //     $('#button_bid_box').prop('disabled', false);
        // }else{
        //     $('#quantity_bid_box').prop('disabled', true);
        //     $('#price_bid_box').prop('disabled', true);
        //     $('#button_bid_box').prop('disabled', true);
        // }

        $('#market-difference-' + id).html(secondsToHms(difference));
        $('#market-status-' + id).html(statusText);
    }

    function secondsToHms(d) {
        d = Number(d);
        var h = Math.floor(d / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);
        var hDisplay = h;
        if (h < 10) {
            hDisplay = '0' + h;
        }
        var mDisplay = m;
        if (m < 10) {
            mDisplay = '0' + m;
        }
        var sDisplay = s;
        if (s < 10) {
            sDisplay = '0' + s;
        }


        return hDisplay + ':' + mDisplay + ':' + sDisplay;
    }

    function change_status_market(id, status) {
        $.ajax({
            url: "{{ route('home.change_market_status') }}",
            data: {
                _token: "{{ csrf_token() }}",
                market_id: id,
                status: status,
            },
            dataType: "json",
            method: 'post',
            success: function (msg) {
                console.log('status changed!')
            }
        })
    }

    window.Echo.channel('new_bid_created')
        .listen('NewBidCreated', function (e) {
            let market_id = e.market_id;
            refreshBidTable(market_id);
        });

    function refreshBidTable(market) {
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
                    $('#bidder_offer').html(msg[1]);
                }
            }
        })
    }
</script>
@yield('script')
