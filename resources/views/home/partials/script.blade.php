<script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts-core.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts.min.js') }}"></script>
<script src="{{ asset('home/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('home/js/moment-timezone.js') }}"></script>
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

    function MarketOnline(id) {
        var MarketSystem = {
            start: function () {
                this.interval = setInterval(function () {
                    refreshMarketTablewithJs(id);
                }, 1000);
            },
            stop: function () {
                clearInterval(this.interval);
                delete this.interval;
                Stop(id);
            },
            finish: function () {
                clearInterval(this.interval);
                delete this.interval;
                finish(id);
            },
        }
        MarketSystem.start();

        async function refreshMarketTablewithJs(id) {
            let market = $('#market-' + id);
            let benchmark1 = market.attr('data-benchmark1');
            let benchmark2 = market.attr('data-benchmark2');
            let benchmark3 = market.attr('data-benchmark3');
            let benchmark4 = market.attr('data-benchmark4');
            let benchmark5 = market.attr('data-benchmark5');
            let benchmark6 = market.attr('data-benchmark6');
            let step = market.attr('data-step');
            let now = moment();
            benchmark1 = new Date(benchmark1);
            benchmark2 = new Date(benchmark2);
            benchmark3 = new Date(benchmark3);
            benchmark4 = new Date(benchmark4);
            benchmark5 = new Date(benchmark5);
            benchmark6 = new Date(benchmark6);
            if (now < benchmark1) {
                waiting_to_open(benchmark1, now, id);
            } else if (benchmark1 < now && now < benchmark2) {
                ready_to_open(benchmark2, now, id)
            } else if (benchmark2 < now && now < benchmark3) {
                opening(benchmark3, now, id)
            } else if (benchmark3 < now && now < benchmark4) {
                Quotation_1_2(benchmark4, now, id);
            } else if (benchmark4 < now && now < benchmark5) {
                Quotation_2_2(benchmark5, now, id);
            } else if (benchmark5 < now && now < benchmark6) {
                Competition(benchmark6, now, id,step);
            } else {
                Stop(id);
            }
        }

        function check_continue_market(market_id, status) {
            let market_continue = true;
            if (status === 4 || status ===6 || status ===7) {
                $.ajax({
                    url: "{{ route('admin.check_market_status_for_continue') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        market_id: market_id,
                        status: status,
                    },
                    dataType: "json",
                    method: "POST",
                    async: false,
                    success: function (msg) {
                        if (msg) {
                            if (msg[1] == 'close') {
                                MarketSystem.stop();
                            }
                            if (msg[1] == 'finish') {
                                MarketSystem.finish();
                            }
                        }
                    }
                })
            }

            return market_continue;
        }

        function waiting_to_open(benchmark1, now, id) {
            deactive_bid();
            let difference = benchmark1 - now;
            let status = 1;
            let statusText = '<span>Waiting To Open</span>';
            let change_color = 0;
            let color = '#6e6e0c';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function ready_to_open(benchmark2, now, id) {
            deactive_bid();
            let difference = benchmark2 - now;
            let status = 2;
            let statusText = '<span>Ready to open</span>';
            let change_color = 1;
            let color = '#8a8a00';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function opening(benchmark3, now, id) {
            active_bid();
            let difference = benchmark3 - now;
            let status = 3;
            let color = '#1f9402';
            let change_color = 1;
            let statusText = '<span>Opening</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function Quotation_1_2(benchmark4, now, id) {
            remove_function();
            active_bid();
            let difference = benchmark4 - now;
            let status = 4;
            let color = '#135e00';
            let change_color = 1;
            let statusText = '<span>Quotation 1/2</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function Quotation_2_2(benchmark5, now, id) {
            remove_function();
            active_bid();
            let difference = benchmark5 - now;
            let status = 5;
            let color = '#104800';
            let change_color = 1;
            let statusText = '<span>Quotation 2/2</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function Competition(benchmark6, now, id,step) {
            $('#bid_price').attr('onkeypress','step_price_competition(this,event)');
            $('#bid_price').attr('step',step);
            remove_function();
            Competition_Bid_buttons();
            let difference = benchmark6 - now;
            let status = 6;
            let color = '#0a2a00';
            let change_color = 1;
            let statusText = '<span>Competition</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function Stop(id) {
            remove_function();
            deactive_bid();
            let difference = 0;
            let status = 7;
            let color = '#ff0707';
            let change_color = 1;
            let statusText = '<span>Close</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function finish(id) {
            remove_function();
            deactive_bid();
            let difference = 0;
            let status = 8;
            let color = '#009800';
            let change_color = 1;
            let statusText = '<span>finish</span>';
            change_market_status(status, difference, change_color, color, statusText, id)
        }

        function change_market_status(status, difference, change_color, color, statusText, id) {
            let previous_status = $('#previous_status-' + id).val();
            $('#previous_status-' + id).val(status);
            difference = parseInt(difference / 1000);
            if (change_color) {
                $('#market-' + id).css('color', color);
                $('.status-box').css('color', color);
                $('.circle_timer').css('background', color);
            }
            $('#market-difference-' + id).html(secondsToHms(difference));
            $('#market-status-' + id).html(statusText);
            if (status != 1) {
                $('#market-time-' + id).html(statusText);
            }
            sales_offer_buttons(status);
            if (previous_status != status) {
                change_status_market(id, status);
                check_continue_market(id, status);
            }
        }
    }

    function active_bid() {
        $('#bid_quantity').prop('disabled', false);
        $('#bid_quantity').addClass('btn-success');

        $('#bid_price').prop('disabled', false);
        $('#bid_price').addClass('btn-success');

        $('#bid_button').prop('disabled', false);
        $('#bid_button').addClass('btn-success');


    }

    function Competition_Bid_buttons() {
        $('#bid_quantity').prop('disabled', true);
        $('#bid_quantity').removeClass('btn-success');

        $('#bid_price').prop('disabled', false);
        $('#bid_price').addClass('btn-success');

        $('#bid_button').prop('disabled', false);
        $('#bid_button').addClass('btn-success');


    }

    function deactive_bid() {
        $('#bid_quantity').val(' ');
        $('#bid_price').val(' ');

        $('#bid_quantity').prop('disabled', true);
        $('#bid_quantity').removeClass('btn-success');

        $('#bid_price').prop('disabled', true);
        $('#bid_price').removeClass('btn-success');

        $('#bid_button').prop('disabled', true);
        $('#bid_button').removeClass('btn-success');
    }

    function Bid(market_id) {
        let is_checked = $('#CheckTermCondition_' + market_id).is(':checked');
        if (!is_checked) {
            window.location.href = "#CheckTermCondition_" + market_id;
            $('#CheckTermCondition_' + market_id).parent().addClass('border-danger');
            alert('Accept Term and Conditions');
            return;
        }
        $('.error_text').hide();
        let price = $('#bid_price').val();
        let quantity = $('#bid_quantity').val();
        $.ajax({
            url: "{{  route('home.bid_market') }}",
            data: {
                price: price,
                quantity: quantity,
                market: market_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",

            beforeSend: function () {
                $('#bid_button').prop('disabled', true);
            },

            success: function (msg) {
                if (msg[0] === 'error') {
                    alert(msg[1]);
                }
                if (msg[0] === 'price_quantity') {
                    $('#bid_' + msg[1] + '_error').text(msg[2]);
                    $('#bid_' + msg[1] + '_error').show();
                }
                if (msg[0] === 'alert') {
                    alert(msg[2]);
                }
                $('#bid_button').prop('disabled', false);
            },
            error: function (msg) {
                if (msg.responseJSON.errors) {
                    let errors = msg.responseJSON.errors;
                    $.each(errors, function (i, val) {
                        $('#bid_' + i + '_error').text(val);
                        $('#bid_' + i + '_error').show();
                    })
                }
                active_bid();
            }
        })

    }

    function competition_bid_buttons() {
        $('#bid_quantity').prop('disabled', true);
    }

    function removeBid(bid_id) {
        $.ajax({
            url: "{{  route('home.remove_bid') }}",
            data: {
                bid_id: bid_id,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",
        })
    }

    function remove_function() {
        $('.remove_function').remove();
    }

    function Offer(market_id) {
        $('.error_text').hide();
        let status = $('#previous_status').val();
        let price_is_disable = $('#seller_price').attr('disabled');
        let price = $('#seller_price').val()
        if (price_is_disable) {
            price = 'disabled';
        }
        let quantity = $('#seller_quantity').val();
        let quantity_is_disable = $('#seller_quantity').attr('disabled');
        if (quantity_is_disable) {
            quantity = 'disabled';
        }
        $.ajax({
            url: "{{  route('home.seller_change_offer') }}",
            data: {
                price: price,
                quantity: quantity,
                market_id: market_id,
                status: status,
                _token: "{{ csrf_token() }}",
            },
            dataType: 'json',
            method: "post",
            success: function (msg) {
                if (msg) {
                    if (msg[1] == 'error') {
                        alert(msg[2]);
                    }
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

    function sales_offer_buttons(status) {
        let seller_quantity = $('#seller_quantity');
        let seller_price = $('#seller_price');
        let seller_button = $('#seller_button');
        if (status == 1) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', true);
        }
        if (status == 2) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', true);
        }
        if (status == 3) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', true);
        }
        if (status == 4) {
            seller_quantity.prop('disabled', false);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', false);
        }
        if (status == 5) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', false);
            seller_button.prop('disabled', false);
        }
        if (status == 6) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', true);
        }
        if (status == 7) {
            seller_quantity.prop('disabled', true);
            seller_price.prop('disabled', true);
            seller_button.prop('disabled', true);
        }
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

            }
        })
    }

    window.Echo.channel('new_bid_created')
        .listen('NewBidCreated', function (e) {
            let market_id = e.market_id;
            refreshBidTable(market_id);
        });
    window.Echo.channel('change-sales-offer')
        .listen('ChangeSaleOffer', function (e) {
            let market_id = e.market_id;
            refreshSellerTable(market_id);
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

    function refreshSellerTable(market) {
        $.ajax({
            url: "{{ route('home.refreshSellerTable') }}",
            data: {
                _token: "{{ csrf_token() }}",
                market: market
            },
            dataType: "json",
            method: 'post',
            success: function (msg) {
                if (msg) {
                    $('#seller_offer_table').html(msg[1]);
                }
            }
        })
    }
</script>
@yield('script')
