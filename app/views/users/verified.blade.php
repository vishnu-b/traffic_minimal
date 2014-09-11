@extends('layouts.users')

@section('head')
    <title>Account Verified</title>
@stop

@section('content')
    @if (!isset($message))
        <h3>Account verified</h3>
        Hi {{ $user }}, you can now sign in from our mobile app to access our services.
    @else
        <h3>Account already verified</h3>
        Your account is already verfied. You can access the services by logging into our mobile app.
    @endif
@stop
