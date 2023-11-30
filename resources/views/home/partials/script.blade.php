<script src="{{ asset('home/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('home/js/popper.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('home/js/amcharts-core.min.js') }}"></script>
<script src="{{ asset('home/js/amcharts.min.js') }}"></script>
<script src="{{ asset('home/js/custom.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.4/moment-timezone-with-data.js"></script>
<script src="{{ asset('home/js/timer.js') }}"></script>
<script src="{{ asset('home/js/yscountdown.min.js') }}"></script>
<script src="{{ asset('home/js/font-awsome.js') }}"></script>
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
</script>
<script>
    // var config = {
    //     endDate: '2024-05-19 09:00',
    //     timeZone: 'Europe/Dublin',
    //     hours: $('#hours'),
    //     minutes: $('#minutes'),
    //     seconds: $('#seconds')
    // };
</script>
@yield('script')
