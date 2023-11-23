<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="@section('meta_keywords'){{ $meta_description }}@show">
    <meta name="keywords" content="@section('meta_keywords'){{ $meta_keywords }}@show">
    <meta name="robots" content="{{ $robot_index==0 ? 'noindex,nofollow' : 'index,follow' }}" />
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/segment7" type="text/css">
    <title>
        @section('title')
            {{ $title }}
        @show
    </title>
    <link rel="icon" href="{{ imageExist(env('SETTING_UPLOAD_PATH'),$fav_icon) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/timer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/developer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/developer.css') }}">
    <link rel="stylesheet" href="{{ asset('home/css/font-awsome.css') }}">
</head>
