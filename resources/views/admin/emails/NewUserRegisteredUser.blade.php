@extends('admin.emails.baseTemplate')

@section('content')
    {!! $message->text !!}

@endsection
